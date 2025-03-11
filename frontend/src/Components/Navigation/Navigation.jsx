import { NavLink, useLocation } from "react-router-dom";
import { useAuth } from '@/Context/AuthContext';
import { useGlobalData } from '@/Context/GlobalDataContext';  
import { addMessage, clearMessagesForComponent } from "@/Helper/SessionStorage";
import { useTranslation } from 'react-i18next'; 
import { getErrorMessage } from '@/Helper/ApiHelper';

export default function Navigation() {
    const componentName = "Navigation";

    const { isAuthenticated, user, logout } = useAuth();
    const { locale, selectedProjectId, selectedProjectTitle, switchLanguage } = useGlobalData();

    const location = useLocation();

    const { t } = useTranslation(['common']); 

    const handleLogout = async () => {
        clearMessagesForComponent(componentName);

        try {
            console.log(componentName + " - handleLogout - try - start");
            await logout();
            //addMessage("success", componentName, 'handleLogout - try', 'Logged out successfully!');
            console.log(componentName + " - handleLogout - try - end");
        } catch (error) {
            console.log(componentName + " - handleLogout - catch - start");
            const errorMsg = getErrorMessage(error);
            console.log(componentName + " - handleLogout - catch - before showMessage");
            addMessage('error', componentName, 'handleLogout - catch', errorMsg);
            console.log(componentName + " - handleLogout - catch - after showMessage");
        } finally {
            console.log(componentName + " - handleLogout - finally");
        }
    };

    const isPathActive = (path) => {
        console.log(componentName + " - isPathActive - ", path);
        return location.pathname.startsWith(path);
    };

    const getNavLinkClass = (path) => isPathActive(path) ? "font-bold text-gray-900" : "text-gray-500 hover:text-orange-500";

    const handleLanguageChange = (e) => {
        const selectedLocale = e.target.value;
        console.log(componentName + " - handleLanguageChange - before switchLanguage - ", selectedLocale);
        switchLanguage(selectedLocale); 
        console.log(componentName + " - handleLanguageChange - after switchLanguage");
        window.location.reload(true);
    };

    return (
        <nav className="pb-5 mb-5 border-b">
            <div className="flex justify-between items-center w-full mx-auto">
                {/* Home - start from left */}
                <ul className="flex space-x-5 items-center list-none p-0 m-0">
                    <li>
                        <NavLink to="/" className={getNavLinkClass('/')}>{t('common:nav_home')}</NavLink>
                    </li>

                    {/* add items - if logged in */}
                    {isAuthenticated && (
                        <>
                            <li className="text-gray-500">|</li>
                            <li>
                                <NavLink to="projects" className={getNavLinkClass('projects')}>{t('common:nav_projects')}</NavLink>
                            </li>

                            {/* add items - if projects is selected */}
                            {isPathActive('/projects') && (
                                <>
                                    <li className="text-sm text-gray-500">|</li>
                                    <li className="text-sm text-orange-500">{selectedProjectTitle}:</li>
                                    {['default', 'byscope', 'latest', 'latesttask', 'chronological', 'withalldetails'].map((page) => {
                                        const link = `projects/${selectedProjectId}/${page}`;
                                        return (
                                            <li key={page}>
                                                <NavLink to={link} className={`text-sm ${getNavLinkClass(link)}`}>
                                                    {t(`common:nav_projects_${page}`)}
                                                </NavLink>
                                            </li>
                                        );
                                    })}
                                </>
                            )}
                            {/* add items - if user is admin */}
                            {user.is_admin && isPathActive('/projects/create') && (
                                <>
                                    <li className="text-sm text-gray-500">|</li>
                                    <li>
                                        <NavLink to="projects/create" className={`text-sm ${getNavLinkClass('projects/create')}`}>{t('common:nav_projects_create')}</NavLink>
                                    </li>
                                </>
                            )}
                        </>
                    )}
                </ul>

                {/* nav items - start from right */}
                <ul className="flex space-x-5 items-center list-none p-0 m-0">

                    {/* language - select box */}
                    <li>
                        <select id="locale" value={locale} onChange={handleLanguageChange} className="bg-gray-500 text-white text-sm border-1 border-t-gray-500 focus:outline-none rounded-md p-1">
                            <option value="en">EN</option>
                            <option value="de">DE</option>
                        </select>
                    </li>

                    {/* add items - if logged in or not */}
                    {isAuthenticated ? (
                        <>
                            <li>
                                <NavLink to="/profile" className={getNavLinkClass('/profile')}>{t('common:nav_profile')}</NavLink>
                            </li>
                            <li className="text-gray-500">|</li>
                            <li>
                                <button onClick={handleLogout} className="text-gray-500 hover:text-orange-500">{t('common:nav_logout')}</button>
                            </li>
                        </>
                    ) : (
                        <>
                            <li>
                                <NavLink to="login" className={getNavLinkClass('login')}>{t('common:nav_login')}</NavLink>
                            </li>
                            <li className="text-gray-500">|</li>
                            <li>
                                <NavLink to="register" className={getNavLinkClass('register')}>{t('common:nav_register')}</NavLink>
                            </li>
                        </>
                    )}
                </ul>
            </div>
        </nav>
    );
}
