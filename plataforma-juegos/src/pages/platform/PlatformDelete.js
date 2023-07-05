import React, { useState, useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';

const PlatformDelete = () => {

  const { message , changeMessage} = useContext(MessageContext);
  const { id } = useParams("");
  const navigate = useNavigate();
  const [initialState, setInitialState] = useState("");


  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.platform.fetch}${id}`)
        .then(response=>{
          setInitialState(`Seguro borrar el elemento ${response.data.nombre}`);

        });
    } catch (error) {
      console.log(error);
    }
  },[id]);


  const clickCheckMarkHandler = () => {
    changeMessage("");
    try {
      axios
        .delete(`${endpoints.platform.delete}${id}`, { header: ('Access-Control-Allow-Origin', '*') })
        .then(response => {
          changeMessage(response.data.mensaje);
          
        });
      
    } catch (error) {
      if (error.response.status === 400) {
        changeMessage(error.response.data.mensaje);
      }    
    }
    navigate("/platforms");

  }

  const clickCloseMarkHandler = () => {
    changeMessage("No se borro plataforma");
    navigate("/platforms");
  }

  return (
    <>
    <Header/>
    <NavBar/>
    <div className="Create-Form">
      <div className="Prueba">
        <p>{ initialState }</p>
        <span>
          <button onClick={ clickCheckMarkHandler }><IoIosCheckmark /></button>
          <button onClick={ clickCloseMarkHandler }><IoIosClose /></button>
        </span>
      </div>
    </div>
    <Footer/>
    </>
  )
}

export default PlatformDelete;
