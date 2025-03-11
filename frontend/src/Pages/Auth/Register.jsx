import { useState, useEffect } from "react";
import axios from "@/axiosConfig";
import config from '@/config';
import { useNavigate } from "react-router-dom";
import { useAuth } from '@/Context/AuthContext'; 
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { addMessage, clearMessagesForComponent, getMessages } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { Button, EmailInput, PasswordInput, TextInput } from "@/Components/FormFields";
import { useTranslation } from 'react-i18next'; 

export default function Register() {
    const componentName = "Auth/Register";
    const prevMessages = getMessages();

    const [name, setName] = useState(''); 
    const [email, setEmail] = useState(''); 
    const [password, setPassword] = useState(''); 
    const [password_confirmation, setPasswordConfirmation] = useState(''); 
    const [registerError, setRegisterError] = useState(false);

    const { login } = useAuth();

    const navigateTo = useNavigate();

    const { t } = useTranslation(['auth']); 

    const handleSubmit = async (e) => {
        e.preventDefault();

        setRegisterError(false);
        clearMessagesForComponent(componentName);

        try {
            //csrf-cookie
            try {
                const csrfResponse = await axios.get(`${config.SANCTUM_URL}/sanctum/csrf-cookie`);
                console.log('CSRF cookie fetched successfully:', csrfResponse.status);
            } catch (csrfError) {
                const errorMsg = getErrorMessage(csrfError);
                console.error('Error fetching CSRF cookie:', errorMsg);
                addMessage('error', componentName, 'csrf - catch', errorMsg);
                setRegisterError(true);
                return; 
            }

            //register
            const response = await axios.post(`${config.API_URL}/register`,
                { name, email, password, password_confirmation }
            );
            console.log(t('auth:register_success'), response.data);
            login(response.data.data.user);

            //clear state and redirect
            setName('');
            setEmail('');
            setPassword('');
            setPasswordConfirmation('');
            setRegisterError(false);
            navigateTo("/");
        } catch (error) {
            const errorMsg = getErrorMessage(error);
            console.log(errorMsg);
            addMessage('error', componentName, 'register - catch', errorMsg);
            setRegisterError(true);
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
                    {(registerError || prevMessages.length > 0) && <GlobalMessage />}

                    <h1 className="text-xl text-orange-600 font-bold text-center mt-8">Register new account</h1>

                    <TextInput
                        id="name"
                        label={t('auth:label_name')}
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                        placeholder={t('auth:placeholder_name')}
                        required={true}
                        autofocus={true}
                        className="input-text"
                        fieldWidth="w-96"
                    />

                    <EmailInput
                        id="email"
                        label={t('auth:label_email')}
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        placeholder={t('auth:placeholder_email')}
                        required={true}
                        className="input-email"
                        fieldWidth="w-96"
                    />

                    <PasswordInput
                        id="password"
                        label={t('auth:label_password')}
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        placeholder={t('auth:placeholder_password')}
                        autocomplete="new-password"
                        required={true}
                        className="input-password"
                        fieldWidth="w-96"
                    />

                    <PasswordInput
                        id="password_confirmation"
                        label={t('auth:label_confirm_password')}
                        value={password_confirmation}
                        onChange={(e) => setPasswordConfirmation(e.target.value)}
                        placeholder={t('auth:placeholder_confirm_password')}
                        autocomplete="new-password"
                        required={true}
                        className="input-password"
                        fieldWidth="w-96"
                    />

                </div>
                
                <div className="flex mr-4 mt-8">
                    <Button
                        type="submit"
                        label={t('auth:label_register_button')}
                        className="text-sm px-4 py-2 mt-4 text-white bg-orange-400 rounded-md hover:bg-orange-500"
                    />
                </div>
            </form>
        </div>
    );
}
