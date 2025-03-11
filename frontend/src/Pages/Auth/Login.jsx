import { useState, useEffect } from "react";
import axios from "@/axiosConfig";
import { useNavigate } from "react-router-dom";
import { useAuth } from '@/Context/AuthContext'; 
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { Button, EmailInput, PasswordInput } from "@/Components/FormFields";
import { addMessage, clearMessagesForComponent, getMessages } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import config from '@/config';
import { useTranslation } from 'react-i18next'; 

export default function Login() {
    const componentName = "Auth/Login";
    const prevMessages = getMessages();

    const [email, setEmail] = useState(''); 
    const [password, setPassword] = useState(''); 
    const [loginError, setLoginError] = useState(false);

    const { login } = useAuth();

    const navigateTo = useNavigate();

    const { t } = useTranslation(['auth']); 

    const handleSubmit = async (e) => {
        e.preventDefault();

        setLoginError(false);
        clearMessagesForComponent(componentName);

        try {
            //csrf-cookie
            try {
                const csrfResponse = await axios.get(`${config.SANCTUM_URL}/sanctum/csrf-cookie`);
                console.log('CSRF cookie fetched successfully:', csrfResponse.status);
            } catch (csrfError) {
                console.error('Error fetching CSRF cookie:', csrfError);
                const csrfErrorMsg = getErrorMessage(csrfError);
                addMessage('error', componentName, 'csrf - catch', csrfErrorMsg);
                setLoginError(true);
                return; 
            }

            //login
            const response = await axios.post(`${config.API_URL}/login`,
                { email, password }
            );
            
            console.log(t('auth:login_success'), response.data);
            login(response.data.data.user);

            //clear state and redirect
            setEmail('');
            setPassword('');
            setLoginError(false);
            navigateTo("/");
        } catch (error) {
            const errorMsg = getErrorMessage(error);
            console.log(errorMsg);
            addMessage('error', componentName, 'login - catch', errorMsg);
            setLoginError(true);
        }
    };

    useEffect(() => {
        //cleanUp - when unmounting
        return () => {
            clearMessagesForComponent(componentName);
        };
    }, []);

    return (
        <div className="flex flex-col flex-grow mx-auto mt-0 mb-0">
            <form onSubmit={handleSubmit}>
                <div className="flex flex-col space-y-8 text-left">
                    {(loginError || prevMessages.length > 0) && <GlobalMessage />}

                    <h1 className="text-xl text-orange-600 font-bold text-center mt-8">Login</h1>

                    <EmailInput
                        id="email"
                        label={t('auth:label_email')}
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder={t('auth:placeholder_email')}
                        required={true}
                        autofocus={true}
                        className="input-email"
                        fieldWidth="w-96"
                    />

                    <PasswordInput
                        id="password"
                        label={t('auth:label_password')}
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        placeholder={t('auth:placeholder_password')}
                        required={true}
                        className="input-password"
                        fieldWidth="w-96"
                    />
                </div>
                <div className="flex mr-4 mt-8">
                    <Button
                        type="submit"
                        label={t('auth:label_login_button')}
                        className="text-sm px-4 py-2 mt-4 text-white bg-orange-400 rounded-md hover:bg-orange-500"
                    />
                </div>
            </form>
        </div>
    );
}
