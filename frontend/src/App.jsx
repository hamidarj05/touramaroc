// src/App.jsx
import React from 'react';
import { BrowserRouter as Router, Route, Routes } from 'react-router-dom';

// Importation des pages
import Accueil from './pages/Accueil/app';
import ToursActivities from './pages/ToursActivities/app';
import Hebergement from './pages/Hebergement/App';
import Evenement from './pages/Evenements/App';
import Transport from './pages/Transport/App';
import Blog from './pages/Blog/App';
import Contact from './pages/Contact/App';

// Importation du composant Header (Navbar)
import Header from './components/Header';

function App() {
  return (
    <Router>
      <Header />   
      <Routes>
        <Route path="/" element={<Accueil />} />
        <Route path="/ToursActivities" element={<ToursActivities />} />
        <Route path="/Hebergement" element={<Hebergement />} />
        <Route path="/Evenement" element={<Evenement />} />
        <Route path="/Transport" element={<Transport />} />
        <Route path="/Blog" element={<Blog />} />
        <Route path="/Contact" element={<Contact />} />
      </Routes>
    </Router>
  );
}

export default App;
