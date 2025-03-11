import { useState, useEffect } from "react";
import axios from "@/axiosConfig";
import config from '@/config';
import { useGlobalData } from '@/Context/GlobalDataContext'; 
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { addMessage, clearMessagesForComponent, getMessages } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { useTranslation } from 'react-i18next'; 
import ScopeList from "@/components/Welcome/ScopeList";

export function Index() {
    const componentName = "Welcome/Index";
    const prevMessages = getMessages();

    const [projectData, setProjectData] = useState(null); 
    const [errorState, setErrorState] = useState(null);
    const [isLoaded, setIsLoaded] = useState(false);

    const { selectedProjectId, switchProject } = useGlobalData();

    const { t } = useTranslation(['common']); 

    useEffect(() => {
        const fetchData = async () => {
            try {
                console.log(componentName + " - useEffect - selectedProjectId - try - start - ", selectedProjectId);
                const response = await axios.get(`${config.API_URL}/welcome?project_id=${selectedProjectId}`);
                setProjectData(response.data.data); 
                setErrorState(null);
                console.log(componentName + " - useEffect - selectedProjectId - try - end - : ", response.data.data);
            } catch (error) {
                console.log(componentName + " - useEffect - selectedProjectId - catch - start");
                const msgError = getErrorMessage(error);
                const msgTxt = componentName + " - useEffect - selectedProjectId - catch - ";
                console.error(msgTxt + msgError);
                setErrorState(msgTxt + msgError); 
                addMessage('error', componentName, 'useEffect - catch', msgError);
                console.log(componentName + " - useEffect - selectedProjectId - catch - end");
            } finally {
                console.log(componentName + " - useEffect - selectedProjectId - finally - start");
                setIsLoaded(true);
                setErrorState(null); 
                console.log(componentName + " - useEffect - selectedProjectId - finally - end");
            }
        };

        console.log(componentName + " - useEffect - selectedProjectId - start");
        clearMessagesForComponent(componentName);
        fetchData(); 
        console.log(componentName + " - useEffect - selectedProjectId - end");
    }, [selectedProjectId]);

    useEffect(() => {
        if (isLoaded && !errorState && projectData) {
            if (projectData.projectId !== selectedProjectId) {
                console.log(componentName + " - before switchProject");
                switchProject(projectData.projectId, projectData.projectTitle);
                console.log(componentName + " - after switchProject");
            }
        }
    }, [isLoaded, errorState, projectData, selectedProjectId, switchProject]);

    useEffect(() => {
        //cleanUp - when unmounting
        return () => {
            clearMessagesForComponent(componentName);
        };
    }, []);

    if (!isLoaded) {
        return <div>Loading...</div>;
    } 
    
    return (
        <div className="flex flex-col flex-grow">
            {(errorState || prevMessages.length > 0) && <GlobalMessage />}

            <h1 className="text-xl text-orange-600 font-bold text-center mt-8 mb-10">{t('common:welcome_to')}{projectData?.projectTitle}!</h1>

            <div className="flex flex-grow w-full gap-8">
                {/* Scopes Left */}
                <ScopeList scopes={projectData?.scopesLeft || []} />

                {/* Scopes Right */}
                <ScopeList scopes={projectData?.scopesRight || []} showDescription={true} />
            </div>
        </div>
    );
}
