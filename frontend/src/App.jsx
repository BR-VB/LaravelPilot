import './App.css';

import './i18n/i18n';

import { useEffect } from 'react';
import { Routes, Route } from "react-router-dom";

import { AuthProvider } from '@/Context/AuthProvider';
import { GlobalDataProvider } from '@/Context/GlobalDataProvider';
import { clearMessages } from "@/Helper/SessionStorage";

import Navigation from "@/Components/Navigation/Navigation";
import ProtectedRoute from "@/Components/Navigation/ProtectedRoute";

import Home from "@/Pages/Home";
import Login from "@/Pages/Auth/Login";
import Register from "@/Pages/Auth/Register";
import ProjectIndex from "@/Pages/Project/Index";
import ProjectShow from "@/Pages/Project/Show";
import ProjectDetails from "@/Pages/Project/Details";
import ProjectCreate from "@/Pages/Project/Create";
import ProjectDelete from "@/Pages/Project/Delete";

import NotFound from "@/Pages/NotFound";

import Footer from "@/Components/Footer/Footer";

function App() {
  useEffect(() => {
    clearMessages();
  });

  return (
    <GlobalDataProvider>
      <AuthProvider>
        <div className="flex flex-col flex-grow mx-auto my-10 w-[95%]">
          <Navigation />
          <Routes>
            <Route path="/" element={<Home />} />
            <Route path="login" element={<Login />} />
            <Route path="register" element={<Register />} />
            {/* Protected Routes */}
            <Route path="projects" element={<ProtectedRoute element={<ProjectIndex />} />} />
            <Route path="projects/:projectId" element={<ProtectedRoute element={<ProjectShow />} />} />
            <Route path="projects/:projectId/delete" element={<ProtectedRoute element={<ProjectDelete />} />} />
            <Route path="projects/:projectId/:view" element={<ProtectedRoute element={<ProjectDetails />} />} />
            <Route path="projects/create" element={<ProtectedRoute element={<ProjectCreate />} />} />
            {/* Route is not defined */}
            <Route path="*" element={<NotFound />} />
          </Routes>
          <Footer />
        </div>
      </AuthProvider>
    </GlobalDataProvider>
  )
}

export default App
