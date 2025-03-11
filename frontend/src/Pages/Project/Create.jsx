import { useState } from "react";
import axios from "@/axiosConfig";
import config from '@/config';
import { Link, useNavigate, useLocation } from "react-router-dom";
import { useGlobalData } from '@/Context/GlobalDataContext'; 
import { Button, TextInput, TextareaInput } from "@/Components/FormFields";
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { addMessage, getMessages, clearMessagesForComponent, getComponentForDelayedClear, setComponentForDelayedClear } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { useTranslation } from 'react-i18next'; 

export default function Create() {
    const componentName = "Project/Create";
    const prevMessages = getMessages();
    const delayedComponent = getComponentForDelayedClear();

    const [title, setTitle] = useState("");
    const [description, setDescription] = useState("");
    const [is_featured, setIsFeatured] = useState(false);
    const [createError, setCreateError] = useState(false);

    const navigateTo = useNavigate();
    const location = useLocation();
    
    const fromPage = location.state?.from || '/';

    const { selectedProjectId, switchProject } = useGlobalData();

    const { t } = useTranslation(['project', 'common']); 

    const handleSubmit = async (e) => {
        e.preventDefault();

        setCreateError(false);
        clearMessagesForComponent(componentName);

        try {
            const response = await axios.post(`${config.API_URL}/projects`, {
                title, description, is_featured,
            });
            addMessage('success', componentName, 'handleSubmit - try', `${t('project:label_project')} (${title}) - ${response?.data?.message}`);
            setComponentForDelayedClear(componentName);
            setTitle("");
            setDescription("");
            setIsFeatured(false);
            setCreateError(false);

            console.log(componentName + ": ", response?.data.data);

            if (selectedProjectId == response?.data.data.projectId) {
                switchProject('', '');
                navigateTo("/");
            } else {
                console.log(componentName + ": before navigateTo fromPage");
                navigateTo(fromPage);
            }
        } catch (error) {
            const msgError = getErrorMessage(error);
            console.error(t('project:message_error_create_project'), msgError);
            addMessage('error', componentName, 'handleSubmit - catch', msgError);
            setCreateError(true);
        }
    }

    return (
        <div className="flex flex-col flex-grow mx-auto mt-0 mb-0 w-full">
            <form onSubmit={handleSubmit}>
                <div className="flex flex-col mx-auto w-[75%]">
                    <div className="flex flex-col mx-auto w-[70%] space-y-8 text-left">
                        {(createError || (prevMessages.length > 0 && delayedComponent != componentName)) && <GlobalMessage />}

                        <h1 className="text-xl text-orange-600 font-bold text-center my-8">{t('project:headline_project_create')}</h1>

                        <TextInput
                            id="title"
                            label={t('project:label_title')}
                            value={title}
                            onChange={(e) => setTitle(e.target.value)}
                            placeholder={t('project:placeholder_title')}
                            required={true}
                            autofocus={true}
                            className="input-text"
                            fieldWidth="w-full"
                        />

                        <TextareaInput
                            id="description"
                            label={t('project:label_description')}
                            value={description}
                            onChange={(e) => setDescription(e.target.value)}
                            placeholder={t('project:placeholder_description')}
                            required={false}
                            className="input-textarea"
                            fieldWidth="w-full"
                            rows={12}
                        />

                        <div className="flex gap-4 mt-8">
                            <Button
                                type="submit"
                                label={t('project:label_create_button')}
                                className="text-sm px-4 py-2 mt-4 text-white bg-orange-400 rounded-md hover:bg-orange-500"
                            />

                            <Link to="/" className="inline-block px-4 py-2 mt-4 text-black border rounded-md hover:bg-gray-200">{t('project:label_cancel_button')}</Link>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    );
}
