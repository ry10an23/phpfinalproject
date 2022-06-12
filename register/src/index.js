import React from 'react';
import ReactDOM from 'react-dom/client';
import {BrowserRouter, Routes, Route} from 'react-router-dom';
// import './index.css';
// import reportWebVitals from './reportWebVitals';
import RegisterForm from './components/register';
import UserInfo from './components/login';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <BrowserRouter>
    <Routes>
      <Route path="/" element={<UserInfo/>}/>
      <Route path="register" element={<RegisterForm/>}/>
    </Routes>
  </BrowserRouter>
);
