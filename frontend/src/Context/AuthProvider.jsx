import { useState, useEffect } from 'react';
import PropTypes from 'prop-types';
import { useGlobalData } from '@/Context/GlobalDataContext'; 
import { AuthContext } from './AuthContext'; 
import axios from '@/axiosConfig'; 
import config from '@/config';
import { addMessage, clearMessagesForComponent } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';

export const AuthProvider = ({ children }) => {
    const componentName = "AuthProvider";

    const [isAuthenticated, setIsAuthenticated] = useState(false);
    const [user, setUser] = useState(null);
    const [loadingState, setLoadingState] = useState({ isCheckingAuth: true, isLoggingOut: false });

    const { locale, selectedProjectId, switchProject, switchLanguage } = useGlobalData();

    const login = (user) => {
        console.log(componentName + " - login - start");
        setIsAuthenticated(true);
        setUser(user);
        if (user?.default_locale && user?.default_locale != locale) {
            switchLanguage(user.default_locale);
        }
        if (user?.default_project_id && user?.default_project_id != selectedProjectId) {
            switchProject(user?.default_project_id,user?.default_project_title);
        }
        console.log(componentName + " - login - end");
    };

    const logout = async () => {
        try {
            console.log(componentName + " - logout - try - start");
            setLoadingState((prev) => ({ ...prev, isLoggingOut: true }));
            await axios.post(`${config.API_URL}/logout`);
            setIsAuthenticated(false); 
            setUser(null);
            switchProject('','');
            sessionStorage.setItem('selectedProjectId', '');
            sessionStorage.setItem('selectedProjectTitle', '');
            console.log(componentName + " - logout - try - end");
        } catch (error) {
            console.log(componentName + " - logout - catch - start");
            const errMsg = getErrorMessage(error);
            console.error(componentName + " - logout - error: ", errMsg);
            console.log(componentName + " - logout - catch - end");
            throw error;
        } finally {
            console.log(componentName + " - logout - finally - start");
            setLoadingState((prev) => ({ ...prev, isLoggingOut: false }));
            console.log(componentName + " - logout - finally - start");
        }
        
    };

    useEffect(() => {
        const checkAuthentication = async () => {
            try {
                console.log(componentName + " - useEffect - checkAuthentication - try - start");
                const response = await axios.get(`${config.API_URL}/user`);
                if (response.status === 200) {
                    setIsAuthenticated(true); 
                    setUser(response.data.data.user);
                    console.log(componentName + " - useEffect - checkAuthentication - status 200 ", response.data.data.user);
                } else {
                    setIsAuthenticated(false); 
                    setUser(null);
                    console.log(componentName + " - useEffect - checkAuthentication - status other: ", response.status);
                }
                console.log(componentName + " - useEffect - checkAuthentication - try - end");
            } catch (error) {
                console.log(componentName + " - useEffect - checkAuthentication - catch - start");
                if (error.response && error.response.status === 401) {
                    console.log(componentName + " - useEffect - checkAuthentication - catch - status 401 - start");
                    setIsAuthenticated(false);
                    setUser(null);
                    console.log(componentName + " - useEffect - checkAuthentication - catch - status 401 - end");
                } else {
                    console.log(componentName + " - useEffect - checkAuthentication - catch - status other - start");
                    const errorMsg = getErrorMessage(error);
                    const errorMsgTxt = 'Error during auth check: ';
                    console.log(errorMsgTxt + errorMsg);

                    addMessage('error', componentName, 'useEffect - catch', errorMsg);

                    setIsAuthenticated(false);
                    setUser(null);
                    console.log(componentName + " - useEffect - checkAuthentication - catch - status other - end");
                }
                console.log(componentName + " - useEffect - checkAuthentication - catch - end");
            } finally {
                console.log(componentName + " - useEffect - checkAuthentication - finally - start");
                setLoadingState((prev) => ({ ...prev, isCheckingAuth: false }));
                console.log(componentName + " - useEffect - checkAuthentication - finally - end");
            }
        };

        console.log(componentName + " - useEffect - start");

        clearMessagesForComponent(componentName);
        checkAuthentication();
        
        console.log(componentName + " - useEffect - end");
    }, [locale, selectedProjectId]);

    return (
        <AuthContext.Provider value={{ isAuthenticated, user, loadingState, login, logout }}>
            {children}
        </AuthContext.Provider>
    );
};

AuthProvider.propTypes = {
    children: PropTypes.node.isRequired, 
};
