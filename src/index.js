import React from 'react';
import ReactDOM from 'react-dom/client';
import './index.css';
import DisplayReservation from './components/DisplayReservation';
import Header from './components/Header';
import BookFlight from './components/BookFlight';

const username='Emma';

const root = ReactDOM.createRoot(document.getElementById('root'));
root.render(
  <React.StrictMode>
    <Header username={username}/>
    <DisplayReservation />
    <BookFlight />
  </React.StrictMode>
);