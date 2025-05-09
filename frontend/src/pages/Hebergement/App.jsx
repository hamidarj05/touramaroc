import { Link } from 'react-router-dom';
import herbergementHeroImage from '../../assets/images/herbergementHeroImage.png' 
import './App.css' 

function Hebergement(){  
  return (
    <section id="herbergementHeroImage" className="herbergementHeroImage section dark-background"> 
            <h3 className="titre"  style={{color:"white"}}>Voir le monde à moindre coût</h3>  
            <img src={herbergementHeroImage} alt="Hero" />
    </section>
  )
}

export default Hebergement; 
