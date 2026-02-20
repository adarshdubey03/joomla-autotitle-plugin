const initAutotitle = () => {
    if (typeof window.autotitleConfig === 'undefined') {
        return;
    }

    const titleField = document.getElementById('jform_title');
    const idField = document.getElementById('jform_id');

    if (!titleField || !idField || idField.value !== "0") {
        return;
    }

    const ajaxUrl = window.autotitleConfig.ajaxUrl;

    fetch(ajaxUrl, {
        method: 'GET'
    })
        .then(response => response.json())
        .then(result => {
            if (result.success && result.data) {
                const titleStr = Array.isArray(result.data) ? result.data[0] : result.data;
                if (titleStr) {
                    titleField.value = titleStr;
                }
            }
        })
        .catch(error => {
            // Silently fail on error to avoid breaking other functionality
        });
};

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initAutotitle);
} else {
    initAutotitle();
}
