import React, { useState , useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';
import Header from '../../components/HeaderComponent';
import NavBar from '../../components/NavBarComponent';
import Footer from '../../components/FooterComponent';

const GenderDelete = ()=>{
  const { id } = useParams("");
  const navigate = useNavigate();
  const { message,changeMessage  } = useContext(MessageContext);

  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.gender.fetch}${id}`)
        .then(response=>{
          changeMessage(`Seguro que desea borrar el elemento "${response.data.nombre}"`);
        });
        
    } catch (error) {
        console.log(error);
        
    }
  },[id])

  const clickCheckMarkHandler = () => {
    changeMessage("");
    axios
      .delete(`${endpoints.gender.delete}${id}`)
      .then(response => {
        changeMessage(response.data.mensaje);
      })
      .catch(error => {
        if (error.response && error.response.status === 400) {
          changeMessage(error.response.data.mensaje);
        } else {
          console.error(error);
        }
      });
    navigate("/genders");
  };
  


  const clickCloseMarkHandler = ()=>{ 
    changeMessage("No se borro genero");
    navigate("/genders");
  }


  return(
    <>
    <Header/>
    <NavBar/>
    <div className="Create-Form">
      <div className="Prueba">
      <p>{ message } </p>
        <span>
          <button onClick={ clickCheckMarkHandler }><IoIosCheckmark/></button>
          <button onClick={ clickCloseMarkHandler }><IoIosClose/></button>
        </span>
      </div>
    </div>
    <Footer/>
    </>
  )
}
export default GenderDelete;