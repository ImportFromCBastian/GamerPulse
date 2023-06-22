import React, { useState , useEffect } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';


const GenderDelete = ()=>{
  const { id } = useParams("");
  const navigate = useNavigate();
  const [genderName, setGenderName] = useState("");
  const [message , setMessage] = useState("");

  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.gender.fetch}${id}`)
        .then(response=>{
          setGenderName(response.data.nombre);
        });
        
    } catch (error) {
        console.log(error);
        
    }
    setMessage(`Seguro que desea borrar el elemento "${genderName}"`);
  },[id])

  const clickCheckMarkHandler = () => {

    axios
      .delete(`${endpoints.gender.delete}${id}`, { header: ('Access-Control-Allow-Origin', '*') })
      .then(response =>{
        setMessage(response.data.mensaje);
      })
      navigate("/genders");

  }
  const clickCloseMarkHandler = ()=>{ 
    navigate("/genders");
  }
  return(
    <div>
      <p>{ message } </p>
      <div>
        <button onClick={ clickCheckMarkHandler }><IoIosCheckmark/></button>
        <button onClick={ clickCloseMarkHandler }><IoIosClose/></button>
      </div>
    </div>
  )
}
export default GenderDelete;