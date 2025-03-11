import i18n from 'i18next';

export const getErrorMessage = (error) => {
    const t = i18n.t;

    if (!error) return t('common:unknown_error');
    
    return (
        error.response?.data?.message ||
        error.response?.data?.errors ||
        error.response?.message ||
        error.message ||
        error ||
        t('common:unknown_error')
    );
};
