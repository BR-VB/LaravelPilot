import { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import axios from "@/axiosConfig";
import config from '@/config';
import { GlobalDataContext } from './GlobalDataContext'; 
import { addMessage, clearMessagesForComponent } from "@/Helper/SessionStorage";
import { useTranslation } from 'react-i18next';
import { getErrorMessage } from '@/Helper/ApiHelper';

export const GlobalDataProvider = ({ children }) => {
    const componentName = "GlobalDataProvider";

    const [locale, setLocale] = useState(sessionStorage.getItem('locale') || 'en');
    const [selectedProjectId, setSelectedProjectId] = useState(sessionStorage.getItem('selectedProjectId') || '');
    const [selectedProjectTitle, setSelectedProjectTitle] = useState(sessionStorage.getItem('selectedProjectTitle') || '');;

    const { i18n } = useTranslation();

    const switchProject = (projectId, projectTitle) => {
        console.log(componentName + " - switchProject - start", projectId, projectTitle);
        setSelectedProjectId(projectId);
        setSelectedProjectTitle(projectTitle);
        sessionStorage.setItem('selectedProjectId', projectId);
        sessionStorage.setItem('selectedProjectTitle', projectTitle);
        console.log(componentName + " - switchProject - end");
    };

    const switchLanguage = (localeParam) => {
        console.log(componentName + " - switchLanguage - start: localeParam");
        setLocale(localeParam);
        i18n.changeLanguage(localeParam);
        sessionStorage.setItem('locale', localeParam);
        console.log(componentName + " - switchLanguage - end");
    };

    useEffect(() => {
        console.log(componentName + " - useEffect - start");
        sessionStorage.setItem('locale', locale);

        //re-read project title and re-set setSelectedProjectTitle + sessionStorage
        if (selectedProjectId) {
            const fetchProjectTitle = async () => {
                try {
                    console.log(`${componentName} - useEffect - fetchProjectTitle - try - start - ${selectedProjectId}`);
                    const response = await axios.get(`${config.API_URL}/projects/${selectedProjectId}`);
                    if (response.data && response.data.data.project.title) {
                        const newProjectTitle = response.data.data.project.title;
                        setSelectedProjectTitle(newProjectTitle);
                        sessionStorage.setItem('selectedProjectTitle', newProjectTitle);
                        console.log(`${componentName} - useEffect - fetchProjectTitle - try - end -  ${newProjectTitle}`);
                    } else {
                        console.warn(`${componentName} - useEffect - fetchProjectTitle - try - no data found `);
                    }
                } catch (error) {
                    if (error.response && error.response.status === 401) {
                        console.error(`${componentName} - useEffect - fetchProjectTitle - catch  - status 401 - start"`, error);
                        sessionStorage.setItem('selectedProjectId', '');
                        sessionStorage.setItem('selectedProjectTitle', '');
                        console.error(`${componentName} - useEffect - fetchProjectTitle - catch  - status 401 - end"`, error);
                    } else {
                        const errorMsg = getErrorMessage(error);
                        console.error(`${componentName} - useEffect - fetchProjectTitle - catch - `, error);
                        addMessage('error', componentName, 'fetchProjectTitle - catch', errorMsg);
                    }
                }
            };

            clearMessagesForComponent(componentName);
            fetchProjectTitle();
        }

        console.log(componentName + " - useEffect - end");
    }, [locale, selectedProjectId]);

    return (
        <GlobalDataContext.Provider value={{ locale, selectedProjectId, selectedProjectTitle, switchProject, switchLanguage }}>
            {children}
        </GlobalDataContext.Provider>
    );
};

GlobalDataProvider.propTypes = {
    children: PropTypes.node.isRequired, 
};
