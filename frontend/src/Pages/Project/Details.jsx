import { useParams} from "react-router-dom";
import { useState, useEffect, useRef } from "react";
import axios from "@/axiosConfig"; 
import config from '@/config';
import { useGlobalData } from '@/Context/GlobalDataContext';  
import GlobalMessage from "@/Components/Messages/GlobalMessage";
import { SelectInput } from "@/Components/FormFields";
import { clearMessagesForComponent, addMessage, getMessages } from "@/Helper/SessionStorage";
import { getErrorMessage } from '@/Helper/ApiHelper';
import { useTranslation } from 'react-i18next'; 
import ReactPaginate from "react-paginate";
import DOMPurify from 'dompurify';

export default function Details() {
    const componentName = "Project/Details";
    const prevMessages = getMessages();

    const { projectId, view } = useParams(); 

    const [projectData, setProjectData] = useState(null); 
    const [projectDataUI, setProjectDataUI] = useState(null); 
    const [scopeId, setScopeId] = useState(0);
    const [error, setError] = useState(null); 

    const [currentPage, setCurrentPage] = useState(1);
    const lastPageRef = useRef(1);

    const viewOldRef = useRef(view);
    const scopeIdOldRef = useRef(0);
    const currentPageOldRef = useRef(1);
    
    const loadingRef = useRef(true);
    const firstRenderRef = useRef(true);

    const { selectedProjectId, switchProject } = useGlobalData();

    const { t } = useTranslation(['project', 'common']);

    const handlePageClick = (event) => {
        setCurrentPage(event.selected + 1); 
    };

    useEffect(() => {
        const fetchData = async () => {
            let pageToGet = currentPage;
            let scopeIdToGet = scopeId;
            if (view !== viewOldRef.current) {
                pageToGet = 1;
                scopeIdToGet = 0;
            }

            loadingRef.current = true;

            try {
                console.log(componentName + " - useEffect - projectId, view, currentPage, scopeId - try - start - (" + projectId + ", " + view + ", " + pageToGet + ", " + scopeIdToGet + ")");
                const response = await axios.get(`${config.API_URL}/projects/${projectId}/${view}?page=${pageToGet}&scopeId=${scopeIdToGet}`);
                setProjectData(response.data.data); 
                if (view === 'byscope' || view === 'chronological' || view === 'withalldetails') {
                    setProjectDataUI(response.data.data?.scopes?.data);
                } else {
                    setProjectDataUI(response.data.data?.scopes);
                }

                viewOldRef.current = view;
                setScopeId(scopeIdToGet);
                scopeIdOldRef.current = scopeIdToGet;
                setCurrentPage(pageToGet);
                currentPageOldRef.current = pageToGet;
                lastPageRef.current = response.data.data?.scopes?.last_page;

                console.log(response.data.data);
                console.log(componentName + " - useEffect - projectId, view, currentPage, scopeId  - try - end - (" + projectId + ", " + view + ", " + pageToGet + ", " + scopeIdToGet + ")");
            } catch (error) {
                console.log(componentName + " - useEffect - projectId, view, currentPage, scopeId   - catch - start - (" + projectId + ", " + view + ", " + pageToGet + ", " + scopeIdToGet + ")");
                setError(error); 
                addMessage('error', componentName, 'fetchData - catch', getErrorMessage(error));
                console.log(componentName + " - useEffect - projectId, view, currentPage, scopeId   - catch - end - (" + projectId + ", " + view + ", " + pageToGet + ", " + scopeIdToGet + ")");
            } finally {
                console.log(componentName + " - useEffect - projectId, view, currentPage, scopeId   - finally - start - (" + projectId + ", " + view + ", " + pageToGet + ", " + scopeIdToGet + ")");
                loadingRef.current = false; 
                setError(null); 
                console.log(componentName + " - useEffect - projectId, view, currentPage, scopeId  - finally - end - (" + projectId + ", " + view + ", " + pageToGet + ", " + scopeIdToGet + ")");
            }
        };

        clearMessagesForComponent(componentName);
        
        if ((view !== viewOldRef.current) || (currentPage !== currentPageOldRef.current) || (scopeId !== scopeIdOldRef.current) || (firstRenderRef.current === true)) {
            firstRenderRef.current = false;
            fetchData(); 
        }
    }, [projectId, view, currentPage, scopeId]); 

    useEffect(() => {
        if (projectData && projectData.project.id !== selectedProjectId) {
            switchProject(projectData.project.id, projectData.project.title);
        }
    }, [projectData, selectedProjectId, switchProject]);

    useEffect(() => {
        //cleanUp - when unmounting
        return () => {
            clearMessagesForComponent(componentName);
        };
    }, []);

    if (loadingRef.current === true) {
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

    const listMode = ['default', 'byscope', 'latest'].includes(viewOldRef.current) ? 'normal' : 'chrono';
    const usePaginate = ['byscope', 'chronological', 'withalldetails'].includes(viewOldRef.current) ? true : false;

    const formattedDescription = projectData?.project?.description ? projectData.project.description.replace(/\n/g, "<br />") : "";

    return (
        <div className="flex flex-col flex-grow mt-0 mb-0">
            {(!error && prevMessages.length > 0)  && <GlobalMessage />}
            
            <h1 className="mt-8 text-xl font-semibold text-center">{projectData?.project.title}</h1>
            
            <div className="mt-12 p-10 text-md text-left bg-gray-100 bg-opacity-20 border-gray-100 border-1 shadow-md rounded-md">
                <span 
                    dangerouslySetInnerHTML={{ __html: formattedDescription }}
                ></span>

                <div className="mt-0 text-md text-left">
                    <ul className="flex gap-2 mt-8 text-sm text-left text-gray-400">
                        <li>{t('common:label_created_at')}: {new Date(projectData?.project.created_at).toLocaleString()},</li>
                        <li>{t('common:label_updated_at')}: {new Date(projectData?.project.updated_at).toLocaleString()}</li>
                    </ul>
                </div>
            </div>

            {/* show scopeId select box for view 'byscope' */}
            {viewOldRef.current === 'byscope' && (
                <div className="mt-8 px-10 py-5 text-md text-left font semi-bold bg-gray-150 bg-opacity-20 border-gray-100 border-1 shadow-md rounded-md">
                    <form>
                        <div className="flex flex-col w-[70%] space-y-8 text-left">
                            <SelectInput
                                id="scopeIdSelect"
                                label={t('scope:label_label')}
                                value={Number(projectData?.scopeId) || 0}
                                onChange={(e) => { setScopeId(Number(e.target.value)); setCurrentPage(1); }}
                                options={Object.entries(projectData?.scopeSelect).map(([key, value]) => ({ value: Number(key), label: value })) || []}
                                required={true}
                                autofocus={false}
                                className="input-select"
                                fieldWidth="w-1/2"
                            /> 
                        </div>
                    </form>
                </div>
            )}
            
            {/* show project details */}
            <div key={viewOldRef.current} className="flex flex-col flex-grow mt-10 mb-0">
                {usePaginate && (
                    <div className="mt-2 px-10 py-2 text-left text-gray-400 font semi-bold bg-gray-200 bg-opacity-20 border-gray-200 border-1 shadow-md rounded-md">
                        <ReactPaginate
                            previousLabel={"←"}
                            nextLabel={"→"}
                            breakLabel={"..."}
                            pageCount={lastPageRef.current}
                            forcePage={currentPage - 1}
                            marginPagesDisplayed={2}
                            pageRangeDisplayed={8}
                            onPageChange={handlePageClick}
                            containerClassName={"pagination"}
                            activeClassName={"active"}
                        />
                    </div>
                )}

                {listMode === 'chrono' ? (
                    projectDataUI?.map((task) => (
                        <div key={`${viewOldRef.current}_${task.scopeId}_${task.taskId}`} style={{ backgroundColor: task.scopeBgcolor }} className="px-10 pt-4 pb-2 my-2 text-left bg-opacity-20 border-1 shadow-md rounded-md">
                            <p className="mb-3 font-bold">{new Date(task.taskOccurredAt).toLocaleString()} - {task.scopeLabel}:</p>
                            <p className="mb-2">{task.taskIcon}{" "}{task.taskPrefix}{" "}
                                <span dangerouslySetInnerHTML={{ __html: task.taskTitle }}></span>
                            </p>
                            {task.taskDescription && (
                                <p className="whitespace-pre-wrap pl-5 mt-2 mb-2" dangerouslySetInnerHTML={{ __html: task.taskDescription }}></p>
                            )}
                            {task.task_details?.length > 0 && (
                                <ul className="mt-0 p-5">
                                    {task.task_details.map((taskdetail) => (
                                        <li key={taskdetail.taskDetailId} className="mb-4">
                                            <strong>
                                                {new Date(taskdetail.taskDetailOccurredAt).toLocaleString()} - {taskdetail.taskDetailTypeLabel}:
                                            </strong>
                                            {taskdetail.taskDetailTypeId === 3 ? (
                                                <pre className="text-xs whitespace-pre-wrap m-0">
                                                    <code>{taskdetail.taskDetailDescription}</code>
                                                </pre>
                                            ) : (
                                                <p className="white-space-pre-wrap break-words leading-tight" dangerouslySetInnerHTML={{ __html: DOMPurify.sanitize(taskdetail.taskDetailDescription) }}></p>
                                            )}
                                        </li>
                                    ))}
                                </ul>
                            )}
                        </div>
                    ))
                ) : (
                    projectDataUI?.map((scope) => (
                        <div key={`${viewOldRef.current}_${scope.scopeId}_${scope.scopeId}`} style={{ backgroundColor: scope.scopeBgcolor }} className="px-10 pt-4 pb-2 my-2 text-left bg-opacity-20 border-1 shadow-md rounded-md">
                            <p className="mb-3 font-bold text-orange-700">{scope.scopeLabel}</p>

                            {scope.tasks?.length > 0 && (
                                scope?.tasks.map((task) => (
                                    <p key={task.taskId}  className="mb-2">{task.taskIcon}{" "}{task.taskPrefix}{" "}
                                        <span dangerouslySetInnerHTML={{ __html: task.taskTitle }}></span>
                                        {task.taskDescription && (
                                            <span className="block break-words px-5 mt-2"
                                                dangerouslySetInnerHTML={{ __html: task.taskDescription.replace(/\n/g, '<br/>') }}
                                            ></span>
                                        )}
                                    </p>
                                ))
                            )}
                        </div>
                    ))
                )}

                {usePaginate && (
                    <div className="mt-2 px-10 py-2 text-left text-gray-400 font semi-bold bg-gray-200 bg-opacity-20 border-gray-200 border-1 shadow-md rounded-md">
                        <ReactPaginate
                        previousLabel={"←"}
                        nextLabel={"→"}
                        breakLabel={"..."}
                        pageCount={lastPageRef.current}
                        forcePage={currentPage - 1}
                        marginPagesDisplayed={2}
                        pageRangeDisplayed={8}
                        onPageChange={handlePageClick}
                        containerClassName={"pagination"}
                        activeClassName={"active"}
                        />
                    </div>
                )}
            </div>
        </div>
    );
}
