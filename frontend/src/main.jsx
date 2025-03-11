import { StrictMode } from 'react';
import ReactDOM from 'react-dom/client';
import App from './App.jsx';
import './index.css';
import './css/navigation.css';
import "./css/form.css";
import "./css/pagination.css";
import "./css/project.css";
import { BrowserRouter } from "react-router-dom";


ReactDOM.createRoot(document.getElementById('root')).render(
    <StrictMode>
        <BrowserRouter future={{ v7_startTransition: true }}>
            <App />
        </BrowserRouter>
    </StrictMode>
)
