import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import DisplayReservation from './components/DisplayReservation';
import Header from './components/Header';

const username='Emma';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <Header username={username}/>
    <DisplayReservation />
  </React.StrictMode>
);

