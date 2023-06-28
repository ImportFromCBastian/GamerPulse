import React, { useState, useEffect } from 'react';
import Header from '../../components/HeaderComponent';
import Footer from '../../components/FooterComponent';
import NavBar from '../../components/NavBarComponent';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import '../../assets/css/generalStyles.css';
import Game from './Game';
const DashboardPage = () => {
  // Estado para almacenar los valores del formulario
  const [filtro, setFiltro] = useState({
    nombre: '',
    id_genero: '',
    id_plataforma: '',
  });
  const [juegos, setJuegos] = useState([]);

  useEffect(() => {
    const fetchData = async () => {
      try {
        const response = await axios.get(`${endpoints.games.get}`);
        setJuegos(response.data);
      } catch (error) {
        console.error(error);
      }
    };

    fetchData();
  }, []);

  
  // Función para manejar cambios en los campos del formulario
  const handleInputChange = (event) => {
    const { name, value } = event.target;
    setFiltro((prevFiltro) => ({
    ...prevFiltro,
    [name]: value,
  }));
  };

  const handleSubmit = async (event) => {
    event.preventDefault();
    const { nombre, id_genero, id_plataforma } = filtro;
    let url = `${endpoints.games.get}`;


    if (nombre) {

      url += `/${nombre}`;

    }

    if (id_genero) {
      url += `/${id_genero}`;
    }

    if (id_plataforma) {
      url += `/${id_plataforma}`;
    }

    try{
      const response = await axios.get(url); 
      console.log(response.data);
      setJuegos(response.data);
      setFiltro({
        nombre: '',
        id_genero: '',
        id_plataforma: '',
      });
    }catch(e){
      console.log(e);
    }
  console.log(url);
  };

  return (
    <div className='fondo'>
      <Header />
      <NavBar />
      <form onSubmit={handleSubmit}>
        <input type="text" name="nombre" placeholder="Filtrar por nombre" value={filtro.nombre} onChange={handleInputChange}/>
        <input type="text" name="id_genero" placeholder="Filtrar por género" value={filtro.id_genero} onChange={handleInputChange} />
        <input type="text" name="id_plataforma" placeholder="Filtrar por plataforma" value={filtro.id_plataforma} onChange={handleInputChange} />
        <button type="submit">Filtrar</button>
      </form>
      <div className='container'>
        {juegos.map((juego) => (
          <Game key={juego.id} nombre={juego.nombre} descripcion={juego.descripcion} imagen={juego.imagen} />
        ))}
      </div>
      <Footer />
    </div>
  );
};

export default DashboardPage;
