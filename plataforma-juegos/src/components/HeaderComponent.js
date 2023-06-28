import React from 'react';
import GamerPulseLogo from '../assets/images/GamerPulse.png';


const Header = () =>{
  return(
    <header className="Header-Logo"> 
      <img className="Logo" src={GamerPulseLogo} alt="logo"/>
    </header>
  )
}

export default Header;