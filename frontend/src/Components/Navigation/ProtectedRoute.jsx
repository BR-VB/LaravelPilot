import { Navigate } from 'react-router-dom';
import { useAuth } from '@/Context/AuthContext';
import PropTypes from 'prop-types';

export default function ProtectedRoute({ element }) {
    const componentName = "ProtectedRoute";

    const { isAuthenticated, loadingState} = useAuth();

    console.log(componentName + " - start");

    if (loadingState.isCheckingAuth) {
        return <div>Loading ... </div>
    }

    if (!isAuthenticated) {
        console.log(componentName + " - NOT authenticated");
        return <Navigate to="/login" />;
    }

    console.log(componentName + " - end");

    return element;
};

ProtectedRoute.propTypes = {
    element: PropTypes.element.isRequired, 
};
