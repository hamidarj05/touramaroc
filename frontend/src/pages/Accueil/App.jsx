import { Link } from 'react-router-dom';
import heroImage from '../../assets/images/heroImage.png'
import Typed from 'typed.js';
import './App.css'
import React, { useRef ,useEffect} from 'react'

function Accueil(){
  const typedElement = useRef(null);

  useEffect(() => {
    const typed = new Typed(typedElement.current, {
      strings: ["Tours marocains", "Réservation d'hôtels", "Activités au Maroc", "Événements au Maroc"],
      typeSpeed: 50,
      backSpeed: 25,
      backDelay: 2000,
      loop: true,
    });

    return () => {
      typed.destroy(); // nettoyage si le composant est démonté
    };
  }, []);
  return (
    <section id="hero" className="heroAccueil section dark-background">
            <img src={heroImage} alt="Hero" />
            <div
              className="container d-flex flex-column align-items-center justify-content-center text-center"
              data-aos="fade-up"
              data-aos-delay="100"
            >
              <h2 style={{color:"white"}}>Bienvenue à TouraMaroc</h2>
              <p>
                <span style={{color:'white'}}
                  className="typed typed-white"
                  ref={typedElement}
                ></span>
              </p>
            </div>
    </section>
  )
}

export default Accueil;
