<div class="body-right contact__details">
    <div class="empty-message text-center">
        <img src="<?php echo e(asset('assets/images/empty-con.png')); ?>" alt="empty">
    </div>
</div>

<?php $__env->startPush('script'); ?>
    <script>
        "use strict";
        (function($) {
            var route = "<?php echo e(route('user.inbox.note.store')); ?>";
            $(".contact__details").on('submit', ".note-wrapper__form", function(e) {
                e.preventDefault();
                const $this = $(this);
                var formData = new FormData($this[0]);
                $.ajax({
                    url: route,
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.status == 'success') {
                            $this.trigger('reset');
                            const note = response.data.note;
                            const html = `<div class="output">
                                        <div>
                                            <p class="text">${note.note}</p>
                                            <span class="date">${new Date(note.created_at).toDateString()}</span>
                                        </div>
                                            <span class="icon deleteNote" data-id="${note.id}"> 
                                                <i class="fas fa-trash text--danger"></i> 
                                        </span>
                                </div>`
                            notify('success', response.message);
                            $(".contact__details").find('.note-wrapper__output').prepend(html);
                        } else {
                            notify('error', response.message || "<?php echo app('translator')->get('Something went wrong'); ?>");
                        }
                    }
                });
            });

            $(".contact__details").on('click', '.note-wrapper__output .deleteNote', function(e) {
                e.preventDefault();

                if (confirm("<?php echo app('translator')->get('Are you sure to delete this note?'); ?>")) {

                    var $this = $(this);
                    var noteId = $this.data('id');
                    var route = "<?php echo e(route('user.inbox.note.delete', ':id')); ?>".replace(':id', noteId);

                    $.post(route, {
                        _token: "<?php echo e(csrf_token()); ?>"
                    }, function(data) {
                        if (data.status == 'success') {
                            $this.closest('.output').remove();
                        }
                        notify(data.status, data.message);
                    });
                }
            });
        })(jQuery);
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /var/www/html/core/resources/views/templates/basic/user/inbox/contact.blade.php ENDPATH**/ ?>