import { useState } from "react";
import { useParams } from "react-router-dom";
import axios from "@/axiosConfig";
import config from '@/config';
import { useNavigate, useLocation } from "react-router-dom";
import { useGlobalData } from '@/Context/GlobalDataContext'; 
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { addMessage, clearMessagesForComponent, getMessages, setComponentForDelayedClear } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { useTranslation } from 'react-i18next'; 

export default function Delete() {
    const componentName = "Project/Delete";
    const prevMessages = getMessages();

    const { projectId } = useParams(); 

    const [deleteError, setDeleteError] = useState(false);

    const navigateTo = useNavigate();
    const location = useLocation();

    const searchParams = new URLSearchParams(location.search);
    const projectTitle = searchParams.get("projectTitle");

    const fromPage = location.state?.from || '/'; 

    const { selectedProjectId, switchProject } = useGlobalData();

    const { t } = useTranslation(['project', 'common']); 

    const handleDelete = async (e) => {
        e.preventDefault();

        setDeleteError(false);
        clearMessagesForComponent(componentName);

        try {
            const response = await axios.delete(`${config.API_URL}/projects/${projectId}`);

            addMessage('success', componentName, 'handleDelete - try', `${t('project:label_project')} (${projectId}/${projectTitle}) - ${response?.data?.message}`);
            setComponentForDelayedClear(componentName);
            setDeleteError(false);

            if (selectedProjectId == projectId) {
                switchProject('', '');
                navigateTo("/");
            } else {
                navigateTo(fromPage);
            }
        } catch (error) {
            const msgError = getErrorMessage(error);
            console.error(t('project:message_error_delete_project'), msgError);
            addMessage('error', componentName, 'handleDelete - catch', msgError);
            setDeleteError(true);
        }
    }

    return (
        <div className="flex flex-col flex-grow mx-auto mt-0 mb-0 w-full">
            {(deleteError || prevMessages.length > 0) && <GlobalMessage />}
            
            <div className="p-4">
                <h1 className="mb-8 mt-8 text-bold">{t('project:headline_project_delete')}</h1>
                <button onClick={handleDelete} className="text-gray-500 hover:text-orange-500">{t('project:label_delete_button')}</button>
            </div>
        </div>
    );
}
