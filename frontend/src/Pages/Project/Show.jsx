import { useParams } from "react-router-dom";
import { useState, useEffect } from "react";
import axios from "@/axiosConfig";
import config from '@/config';
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { getMessages, addMessage, clearMessagesForComponent } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { useTranslation } from 'react-i18next'; 

export default function Show() {
    const componentName = "Project/Show";
    const prevMessages = getMessages();

    const { projectId } = useParams(); 
    const [projectData, setProjectData] = useState(null); 
    const [loading, setLoading] = useState(true); 
    const [error, setError] = useState(null); 

    const { t } = useTranslation(['project', 'common']);

    useEffect(() => {
        const fetchData = async () => {
            try {
                const response = await axios.get(`${config.API_URL}/projects/${projectId}`);
                setProjectData(response.data.data); 
                setLoading(false); 
            } catch (error) {
                setError(error.message); 
                setLoading(false); 
                addMessage('error', componentName, 'fetchData - catch', getErrorMessage(error));
            }
        };

        clearMessagesForComponent(componentName);
        fetchData(); 
    }, [projectId]); 

    useEffect(() => {
        //cleanUp - when unmounting
        return () => {
            clearMessagesForComponent(componentName);
        };
    }, []);

    if (loading) {
        return <div>Loading...</div>; 
    }

    if (error || !projectData) {
        if (!projectData) {
            const msgError = t('no_data_found') + "!";
            console.log(componentName + ": "), msgError;
            addMessage('error', componentName, 'fetchData - try', msgError);
        }

        return (
            <div className="flex flex-col flex-grow mx-auto mt-0 mb-0">
                <GlobalMessage />
            </div>
        ); 
    }

    const formattedDescription = projectData?.project?.description ? projectData.project.description.replace(/\n/g, "<br />") : "";
    
    return (
        <div className="flex flex-col flex-grow mx-auto mt-0 mb-0">
            {(!error && prevMessages.length > 0)  && <GlobalMessage />}

            <h1 className="mt-8 text-xl font-semibold text-center">{projectData.project.title}</h1>

            <div className="mt-15 text-md text-left">
                <span 
                    dangerouslySetInnerHTML={{ __html: formattedDescription }}
                ></span>
            </div>
            
            <ul className="mt-10 text-sm text-left text-gray-400">
                <li>{t('common:label_created_at')}: {new Date(projectData.project.created_at).toLocaleString()}</li>
                <li>{t('common:label_updated_at')}: {new Date(projectData.project.updated_at).toLocaleString()}</li>
            </ul>

            {/* show project details */}
        </div>
    );
}
