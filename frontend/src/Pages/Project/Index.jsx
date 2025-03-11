import { useState, useEffect } from "react";
import { NavLink, useLocation } from "react-router-dom";
import axios from "@/axiosConfig";
import config from '@/config';
import { useAuth } from '@/Context/AuthContext';
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { addMessage, clearMessagesForComponent, getMessages } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { useTranslation } from 'react-i18next'; 

export default function Index() {
    const componentName = "Project/Index";
    const prevMessages = getMessages();

    const location = useLocation();

    const { isAuthenticated, user } = useAuth();
    
    const [projectData, setProjectData] = useState(null); 
    const [isLoaded, setIsLoaded] = useState(false);
    const [fetchDataError, setFetchDataError] = useState(false);

    const { t } = useTranslation(['project', 'common']);

    useEffect(() => {
        const fetchData = async () => {
            try {
                console.log(componentName + " - useEffect - try - start");
                const response = await axios.get(`${config.API_URL}/projects`);
                console.log(componentName + " - useEffect - try - response available");
                setProjectData(response.data.data); 
                setIsLoaded(true);
                setFetchDataError(false);
                console.log(componentName + " useEffect - try - end");
            } catch (error) {
                setIsLoaded(true);
                setFetchDataError(true);
                const errorMsg = getErrorMessage(error);
                const errorMsgTxt = 'Error fetching project data: ';
                console.log(errorMsgTxt + errorMsg);
                addMessage('error', componentName, 'fetchData - catch', errorMsg);
            }
        };

        clearMessagesForComponent(componentName);
        fetchData(); 

    }, []);

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
        <div className="flex flex-col flex-grow mx-auto mt-0 mb-0">
            {(fetchDataError || prevMessages.length > 0) && <GlobalMessage />}

            <h1 className="text-xl text-orange-600 font-bold text-center mt-8">{t('project:headline_project_overview')}</h1>
            <div className="mt-8">
                {projectData?.map((project) => (
                    <div key={project.id} className="flex justify-start space-x-5 p-3 my-3 rounded-md shadow-sm text-left">
                        <h4 className="w-80 font-gray">{project.title}</h4>
                        <div>
                            <ul className="flex justify-start items-center space-x-5 list-none p-0 m-0">
                                <li>
                                    <NavLink to={`/projects/${project.id}/default`} title={t('common:nav_projects_default_hover')} className="text-orange-500 hover:text-orange-700">
                                        <i className="fas fa-eye mr-2"></i>
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink to={`/projects/${project.id}/byscope`} title={t('common:nav_projects_byscope_hover')} className="text-orange-500 hover:text-orange-700">
                                        <i className="fas fa-bullseye mr-2"></i>
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink to={`/projects/${project.id}/latest`} title={t('common:nav_projects_latest_hover')} className="text-orange-500 hover:text-orange-700">
                                        <i className="fas fa-clock mr-2"></i>
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink to={`/projects/${project.id}/latesttask`} title={t('common:nav_projects_latesttask_hover')} className="text-orange-500 hover:text-orange-700">
                                        <i className="fas fa-tasks mr-2"></i>
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink to={`/projects/${project.id}/chronological`} title={t('common:nav_projects_chronological_hover')} className="text-orange-500 hover:text-orange-700">
                                        <i className="fas fa-calendar-alt mr-2"></i>
                                    </NavLink>
                                </li>
                                <li>
                                    <NavLink to={`/projects/${project.id}/withalldetails`} title={t('common:nav_projects_withalldetails_hover')} className="text-orange-500 hover:text-orange-700">
                                        <i className="fas fa-file-alt mr-2"></i>
                                    </NavLink>
                                </li>
                                {isAuthenticated && user.is_admin && (
                                    <>
                                        <li className="text-gray-500">|</li>
                                        <li>
                                            <NavLink to={`/projects/${project.id}/delete?projectTitle=${project.title}`} state={{ from: location.pathname}} title={t('project:headline_project_delete')} className="text-red-500 hover:text-red-700">
                                                <i className="fas fa-trash mr-2"></i>
                                            </NavLink>
                                        </li>
                                    </>
                                )}
                            </ul>
                        </div>
                    </div>
                ))}
            </div>
            <div className="mt-5">
                <ul className="flex justify-start space-x-5 list-none p-0 m-0">
                    {isAuthenticated && user.is_admin && (
                        <li>
                            <NavLink to={`/projects/create`} state={{ from: location.pathname}} title={t('project:headline_project_create')} className="w-4 h-4 bg-orange-500 text-white rounded-full inline-flex items-center justify-center hover:bg-orange-700">
                                <i className="fas fa-plus text-[10px]"></i>
                            </NavLink>
                        </li>
                    )}
                </ul>
            </div>
        </div>
    );
}
