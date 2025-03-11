<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('model-form');
        const toggleButton = document.getElementById('toggle-edit-button');
        const isEditMode = "{{ $isEditMode }}";
        const modelId = "{{ $modelId }}";
        const modelRoute = "{{ $modelRoute }}";

        if (toggleButton) {
            toggleButton.addEventListener('click', function() {
                if (!isEditMode) {
                    form.action = modelRoute.replace(':id', modelId);
                    form.querySelectorAll('input, select, textarea').forEach(field => field.removeAttribute('disabled'));
                    form.insertAdjacentHTML('beforeend', '@method("GET")');
                    this.textContent = "{{ __('model.edit_submit_label') }}";
                } else {
                    form.submit();
                }
            });
        }
    });
</script>