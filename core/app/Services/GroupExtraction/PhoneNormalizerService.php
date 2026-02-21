<?php

namespace App\Services\GroupExtraction;

use libphonenumber\NumberParseException;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;

class PhoneNormalizerService
{
    public function normalize(?string $rawPhone, ?string $defaultRegion = 'PK'): array
    {
        $rawPhone = trim((string) $rawPhone);
        if ($rawPhone === '') {
            return [
                'valid' => false,
                'reason' => 'empty_phone',
            ];
        }

        $normalizedInput = preg_replace('/\s+/', '', $rawPhone);
        if (str_starts_with($normalizedInput, '00')) {
            $normalizedInput = '+' . substr($normalizedInput, 2);
        }

        $util = PhoneNumberUtil::getInstance();
        $region = strtoupper(trim((string) ($defaultRegion ?: 'PK')));
        if ($region === '') {
            $region = 'PK';
        }

        try {
            $number = $util->parse($normalizedInput, $region);
        } catch (NumberParseException $exception) {
            return [
                'valid' => false,
                'reason' => 'parse_error',
                'detail' => $exception->getMessage(),
            ];
        }

        if (!$util->isPossibleNumber($number) || !$util->isValidNumber($number)) {
            return [
                'valid' => false,
                'reason' => 'invalid_number',
            ];
        }

        $e164 = $util->format($number, PhoneNumberFormat::E164);
        $countryCode = (string) $number->getCountryCode();
        $nationalNumber = (string) $number->getNationalNumber();
        $digits = preg_replace('/\D+/', '', $e164);

        return [
            'valid' => true,
            'e164' => $e164,
            'country_code' => $countryCode,
            'mobile_code' => '+' . $countryCode,
            'national_number' => $nationalNumber,
            'digits' => $digits,
        ];
    }
}

