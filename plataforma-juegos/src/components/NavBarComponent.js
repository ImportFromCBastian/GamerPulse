import React from 'react';
import { Link } from 'react-router-dom';

const NavBar = () =>{
  return(
    <div>
      <nav className="NavBar">
        <Link to="/">
          Listado de Juegos
        </Link>
        <Link to="/genders">
          Listado de Generos
        </Link>
        <Link to="/platforms">
          Listado de Plataformas
        </Link>
      </nav>
    </div>
  )
}

export default NavBar;