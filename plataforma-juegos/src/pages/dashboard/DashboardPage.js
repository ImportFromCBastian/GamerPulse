import React, { useState, useEffect } from 'react';
import Header from '../../components/HeaderComponent';
import Footer from '../../components/FooterComponent';
import NavBar from '../../components/NavBarComponent';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import '../../assets/css/generalStyles.css';
import Game from './Game';
import { FaArrowUp, FaArrowDown, FaArrowsAltV } from 'react-icons/fa';
import Dropdown from './DropDown';

const DashboardPage = () => {
  const [vacio, setVacio] = useState(null);

  const [filtro, setFiltro] = useState({
    nombre: '',
    id_genero: '',
    id_plataforma: '',
    orden: 'ASC'
  });

  const [juegos, setJuegos] = useState([]);

  const fetchData = async () => {
    try {
      const response = await axios.get(`${endpoints.games.get}`);
      setJuegos(response.data);
    } catch (error) {
      console.error(error);
    }
  };

  useEffect(() => {
    fetchData();
  }, []);

  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setFiltro((prevFiltro) => ({
      ...prevFiltro,
      [name]: value,
    }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();

    const { nombre, id_genero, id_plataforma, orden } = filtro;
    let url = `${endpoints.games.get}`;
  
    if (nombre) {
      url += `?nombre=${nombre}`;
    }
    if (id_genero) {
      url += `${nombre ? '&' : '?'}genero=${id_genero}`;
    }
    if (id_plataforma) {
      url += `${nombre || id_genero ? '&' : '?'}plataforma=${id_plataforma}`;
    }
    if (orden) {
      url += `${nombre || id_genero || id_plataforma ? '&' : '?'}orden=${orden}`;
    }
  
    try {
      const response = await axios.get(url);
      setJuegos(response.data);
      if (response.data.mensaje) {
        setVacio(response.data.mensaje);
      } else {
        setVacio(null);
      }
    } catch (e) {
      console.log(e);
    }
  };
  

  const handleOrdenClick = () => {
    let nuevoOrden;
    if (filtro.orden === 'ASC') {
      nuevoOrden = 'DESC';
    } else {
      nuevoOrden = 'ASC';
    }
    setFiltro((prevFiltro) => ({
      ...prevFiltro,
      orden: nuevoOrden
    }));
  };
  
  const [generos, setGeneros] = useState([]);
  const [plataformas, setPlataformas] = useState([]);

  useEffect(() => {
    const fetchGeneros = async () => {
      try {
        const response = await axios.get(`${endpoints.gender.get}`);
        setGeneros(response.data);
      } catch (error) {
        console.error(error);
      }
    };

    const fetchPlataformas = async () => {
      try {
        const response = await axios.get(`${endpoints.platform.get}`);
        setPlataformas(response.data);
      } catch (error) {
        console.error(error);
      }
    };
    
    fetchGeneros();
    fetchPlataformas();
  }, []);
  
  return (
    <div className='fondo'>
      <Header />
      <NavBar />
      <div className="Flex-Center">

        <form className="Filter-Form" onSubmit={handleSubmit}>
          <p className="Filter-Marker">Filtro</p>
          <input className="Name-Input"type='text' name='nombre' placeholder='Filtrar por nombre' value={filtro.nombre} onChange={handleInputChange}/>      

          <Dropdown name='id_genero' placeholder='Filtrar por género' value={filtro.id_genero} options={generos} onChange={handleInputChange}/>

          <Dropdown name='id_plataforma' placeholder='Filtrar por plataforma' value={filtro.id_plataforma} options={plataformas} onChange={handleInputChange}/>

          <button className="Form-Submit" type='submit'>Filtrar</button>

          <button type='button' onClick={handleOrdenClick}>
            {filtro.orden === 'ASC' && <FaArrowUp />}
            {filtro.orden === 'DESC' && <FaArrowDown />}
          </button>

        </form>
      </div>
      <div className='container'>
      {Array.isArray(juegos) && juegos.map(({id,nombre,imagen,tipo_imagen,descripcion,url,id_genero,id_plataforma}) => (
          <Game key={id} elem={{nombre,imagen,tipo_imagen,descripcion,url,id_genero,id_plataforma}} />
        ))}
        {vacio ? (
          <Game key={0} elem={{nombre:"No se encontraron resultados",imagen:'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',tipo_imagen:"image/png",descripcion:"",url:"",id_genero:0,id_plataforma:0}} />
        ) : null}
      </div>
      <Footer />
    </div>
  );
};

export default DashboardPage;
