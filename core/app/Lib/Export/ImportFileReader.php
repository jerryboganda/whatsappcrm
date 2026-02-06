<?php

namespace App\Lib\Export;

use App\Models\ContactList;
use Carbon\Carbon;
use Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportFileReader
{
    /*
    |--------------------------------------------------------------------------
    | Import File Reader
    |--------------------------------------------------------------------------
    |
    | This class basically generated for read data or insert data from user import file
    | several kind of files read here
    | like csv,xlsx,csv
    |
    */

    public $dataInsertMode = true;

    /**
     * colum name of upload file ,like name,email,mobile,etc
     * colum name must be same of target table colum name
     *
     * @var array
     */
    public $columns = [];

    /**
     * Aliases for columns to support flexible mapping
     * Format: ['db_column' => ['alias1', 'alias2']]
     * @var array
     */
    public $aliases = [];

    /**
     * Map of DB column name => File column index (Fallback if no headers found)
     * @var array
     */
    public $fallbackMap = [];

    /**
     * Map of DB column name => File column index
     * @var array
     */
    public $headerMap = [];

    /**
     * check the value exits on DB: table
     *
     * @var array
     */

    public $uniqueColumns = [];

    /**
     * on upload model class
     *
     * @var string
     */
    public $modelName;

    /**
     * upload file
     *
     * @var object
     */
    public $file;

    /**
     * supported input file extensions
     *
     * @var array
     */
    public $fileSupportedExtension = ['csv', 'xlsx', 'xls', 'txt'];


    /**
     * Here store all data from read text,csv,excel file
     *
     * @var array
     */

    public $allData = [];

    /**
     * Here could be pre-defined reference data like contactList,contactTags
     *
     * @var array
     */

    public $references = [];

    /**
     * ALL Unique data store here
     */
    public $allUniqueData = [];

    public $notify;


    public function __construct($file, $modelName = null)
    {
        $this->file = $file;
        $this->modelName = $modelName;
    }

    public function readFile()
    {
        $fileExtension = $this->file->getClientOriginalExtension();

        if (!in_array(strtolower($fileExtension), $this->fileSupportedExtension)) {
            return $this->exceptionSet("File type not supported ($fileExtension)");
        }
        $spreadsheet = IOFactory::load($this->file);

        $data = array_filter($spreadsheet->getActiveSheet()->toArray(), function ($row) {
            return array_filter($row, fn($value) => $value !== null && trim($value) !== '') !== [];
        });

        if (count($data) <= 0) {
            return $this->exceptionSet("File can not be empty");
        }

        // Re-index data to ensure 0-based sequential array keys after filtering
        $data = array_values($data);

        $headersFound = $this->validateFileHeader(array_filter(@$data[0]));

        if ($headersFound) {
            unset($data[0]);
        }

        foreach ($data as $item) {
            $item = array_map('trim', $item);
            $this->dataReadFromFile($item);
        }
        ;

        return $this->saveData();
    }

    public function validateFileHeader($fileHeader)
    {
        // 1. Normalize file headers: trim, lowercase
        $normalizedHeaders = [];
        foreach ($fileHeader as $index => $header) {
            $normalizedHeaders[$index] = strtolower(trim($header));
        }

        $this->headerMap = [];
        $foundColumns = 0;

        // 2. Map required columns to file indices
        foreach ($this->columns as $dbCol) {
            $dbColLower = strtolower($dbCol);
            $mapped = false;

            // Strategy A: Exact Match
            $index = array_search($dbColLower, $normalizedHeaders);
            if ($index !== false) {
                $this->headerMap[$dbCol] = $index;
                $mapped = true;
            } else {
                // Strategy B: Alias Match
                if (isset($this->aliases[$dbCol]) && is_array($this->aliases[$dbCol])) {
                    foreach ($this->aliases[$dbCol] as $alias) {
                        $aliasLower = strtolower($alias);
                        $index = array_search($aliasLower, $normalizedHeaders);
                        if ($index !== false) {
                            $this->headerMap[$dbCol] = $index;
                            $mapped = true;
                            break;
                        }
                    }
                }
            }

            if ($mapped) {
                $foundColumns++;
            }
        }

        // If columns found, return true (Headers Exist)
        if ($foundColumns > 0) {
            return true;
        }

        // 3. Fallback: If no headers found, check if we have a fallback map
        if (!empty($this->fallbackMap)) {
            $this->headerMap = $this->fallbackMap;
            return false; // False means "No Headers Found" (so don't skip first row)
        }

        $this->exceptionSet("No valid columns found in header. Expected: " . implode(', ', $this->columns));
        return false;
    }

    public function dataReadFromFile($data)
    {
        if (!is_array($data)) {
            return; // Skip invalid rows
        }

        $mappedData = [];
        $hasData = false;

        foreach ($this->columns as $dbCol) {
            if (isset($this->headerMap[$dbCol])) {
                $index = $this->headerMap[$dbCol];
                $val = isset($data[$index]) ? trim((string) $data[$index]) : '';
                $mappedData[] = $val;
                if ($val !== '')
                    $hasData = true;
            } else {
                $mappedData[] = ''; // Default empty if column missing
            }
        }

        if (!$hasData)
            return; // Skip empty rows

        if ($this->dataInsertMode && (!$this->uniqueColumCheck($mappedData))) {
            // We need to re-combine with keys for standard processing if needed,
            // but uniqueColumCheck usually expects indexed array matching $this->columns order
            $this->allUniqueData[] = array_combine($this->columns, $mappedData);
        }

        $this->allData[] = $mappedData;
    }

    function uniqueColumCheck($data)
    {
        $user = getParentUser();

        // data is indexed [0=>firstname, 1=>lastname, 2=>code, 3=>mobile] based on $this->columns order in ContactManager

        // Dynamic check: find index of 'mobile_code' and 'mobile' in $this->columns
        $codeIdx = array_search('mobile_code', $this->columns);
        $mobileIdx = array_search('mobile', $this->columns);

        $dialCodeValue = ($codeIdx !== false) ? ($data[$codeIdx] ?? null) : null;
        $mobileValue = ($mobileIdx !== false) ? ($data[$mobileIdx] ?? null) : null;

        if ($mobileValue) {
            $query = $this->modelName::where('user_id', $user->id)->where('mobile', $mobileValue);
            if ($dialCodeValue) {
                $query->where('mobile_code', $dialCodeValue);
            }
            return $query->exists();
        }

        return false;
    }

    public function saveData()
    {
        $user = getParentUser();

        if (!featureAccessLimitCheck($user->contact_limit, count($this->allUniqueData))) {
            $this->exceptionSet('You have reached the maximum number of contact limit');
        }

        if (count($this->allUniqueData) > 0 && $this->dataInsertMode) {
            try {
                $this->allUniqueData = array_map(function ($data) use ($user) {
                    $data['user_id'] = $user->id;
                    $data['created_at'] = Carbon::now();
                    $data['updated_at'] = Carbon::now();
                    return $data;
                }, $this->allUniqueData);

                $this->modelName::insert($this->allUniqueData);

                $insertedIds = $this->modelName::where('user_id', $user->id)
                    ->latest('id')
                    ->take(count($this->allUniqueData))
                    ->pluck('id')
                    ->toArray();

                if (!empty($insertedIds) && !empty($this->references['contact_list_id'])) {
                    $contactListId = $this->references['contact_list_id'];

                    $pivotData = [];
                    foreach ($insertedIds as $contactId) {
                        $pivotData[$contactId] = ['created_at' => Carbon::now()];
                    }

                    $contactList = ContactList::find($contactListId);

                    if ($contactList) {
                        $contactList->contact()->syncWithoutDetaching($pivotData);
                    }
                }

                decrementFeature($user, 'contact_limit', count($this->allUniqueData));

            } catch (Exception $e) {
                // Log exception for debugging but return generalized message
                // Log::error($e->getMessage());
                $this->exceptionSet('This file can\'t be uploaded. It may contains duplicate data or invalid format.');
            }
        }

        $this->notify = count($this->allUniqueData) . " data added successfully total " . count($this->allData) . ' data';
    }


    public function exceptionSet($exception)
    {
        throw new Exception($exception);
    }

    public function getReadData()
    {
        return $this->allData;
    }

    public function notifyMessage()
    {
        return $this->notify;
    }
}
