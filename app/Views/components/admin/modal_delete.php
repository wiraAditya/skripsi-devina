<?php
/**
 * Reusable Delete Modal Component
 * 
 * @param string $modalId - ID for the modal (default: 'deleteModal')
 * @param string $title - Modal title (default: 'Hapus Data')
 * @param string $message - Confirmation message (default: 'Apakah Anda yakin ingin menghapus data ini?')
 * @param string $formId - ID for the form (default: 'deleteForm')
 */

$modalId = isset($modalId) ? $modalId : 'deleteModal';
$title = isset($title) ? $title : 'Hapus Data';
$message = isset($message) ? $message : 'Apakah Anda yakin ingin menghapus data ini? Data yang sudah dihapus tidak dapat dikembalikan.';
$formId = isset($formId) ? $formId : 'deleteForm';
?>

<div id="<?= $modalId ?>" class="fixed z-50 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/30 backdrop-blur-sm transition-opacity" aria-hidden="true"></div>

        <!-- Modal panel -->
        <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        <i class="fas fa-exclamation text-red-600"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                            <?= $title ?>
                        </h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-500">
                                <?= $message ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <form id="<?= $formId ?>" method="POST" action="">
                    <?= csrf_field() ?>
                    <input type="hidden" name="_method" value="DELETE">
                    <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Hapus
                    </button>
                </form>
                <button onclick="hideModal('<?= $modalId ?>')" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    Batal
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function showModal(modalId, formAction = null, formId = 'deleteForm') {
    const modal = document.getElementById(modalId);
    if (formAction) {
        const form = document.getElementById(formId);
        form.action = formAction;
    }
    modal.classList.remove('hidden');
    document.body.classList.add('modal-open');
}

function hideModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
    document.body.classList.remove('modal-open');
}
</script>