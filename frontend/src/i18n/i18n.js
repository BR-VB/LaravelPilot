import i18n from 'i18next';
import { initReactI18next } from 'react-i18next';
import HttpApi from 'i18next-http-backend';

i18n
    .use(HttpApi) 
    .use(initReactI18next)
    .init({
        lng: sessionStorage.getItem('locale') || 'en',
        supportedLngs: ['en', 'de'], 
        fallbackLng: 'en', 
        debug: true,
        interpolation: {
            escapeValue: false, //XSS-savety - not neccessary for React
        },
        backend: {
            loadPath: (lng, ns) => `/locales/${lng}/${ns}.json`,
        },
        ns: ['auth', 'common', 'project', 'scope'], 
        defaultNS: 'common',
    });

export default i18n;
