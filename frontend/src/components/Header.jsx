import React, { useEffect } from 'react';
import { Link } from 'react-router-dom'; 
import '../App.css';

function Header() { 
  useEffect(() => {
    const navLinks = document.querySelectorAll('.nav-link');
    navLinks.forEach(link => {
      link.addEventListener('click', () => {
        navLinks.forEach(l => l.classList.remove('active'));
        link.classList.add('active');
      });
    });

    return () => {
      navLinks.forEach(link => {
        link.removeEventListener('click', () => {});
      });
    };
  }, []);

  return (
    <header>
      <nav className="navbar navbar-expand-lg fixed-top">
        <div className="container-fluid">
          <Link style={{ color: 'blue', fontSize: "30px", fontWeight: "bold" }}
            className="navbar-brand me-auto" to="/">TouraMaroc</Link>
          <div
            className="offcanvas offcanvas-end"
            tabIndex="-1"
            id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel"
          >
            <div className="offcanvas-header"> 
              <button
                type="button"
                className="btn-close"
                data-bs-dismiss="offcanvas"
                aria-label="Close"
              ></button>
            </div>
            <div className="offcanvas-body">
              <ul id="navbar-nav" className="navbar-nav justify-content-center flex-grow-1 pe-3">
                <li className="nav-item">
                  <Link className="nav-link" aria-current="page" to="/">
                    Accueil
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/Hebergement">
                    Hébergement
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/ToursActivities">
                    Tours & Activities
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/Evenement">
                    Evénement
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/Transport">
                    Transport
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/Blog">
                    Blog
                  </Link>
                </li>
                <li className="nav-item">
                  <Link className="nav-link" to="/Contact">
                    Contact
                  </Link>
                </li>
              </ul>
            </div>
          </div>
          <div className='d-flex me-0'>
            <select name="lang" id="lang" className='form-select me-1'>
              <option value="fr">Français</option>
              <option value="ar">العربية</option>
              <option value="en">English</option>
            </select>
            <Link className='btn btn-primary'>Connexion</Link>
          </div>
          <button
            className="navbar-toggler"
            type="button"
            data-bs-toggle="offcanvas"
            data-bs-target="#offcanvasNavbar"
            aria-controls="offcanvasNavbar"
            aria-label="Toggle navigation"
          >
            <span className="navbar-toggler-icon"></span>
          </button>
        </div>
      </nav> 
    </header> 
  );
}

export default Header;
