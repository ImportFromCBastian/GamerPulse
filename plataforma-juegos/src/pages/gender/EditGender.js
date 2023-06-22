import React, { useState } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';


const EditGender = () => {

  const { id , name} = useParams("");
  const navigate = useNavigate();
  const [inputValue,setInputValue] = useState(name);
  const [selected, setSelected] = useState("")
  const [message,setMessage] = useState(`Modificando elemento ${name}`);

  const submitHandler = event => {
    event.preventDefault();
    if(selected && inputValue !== ""){
      try{
        axios
          .put(`${endpoints.gender.put}/${id}`, { nombre: inputValue }, { header: ('Access-Control-Allow-Origin', '*') })
          .then(response => {
            setMessage(response.data.mensaje);
          });

      }catch(error){
        console.log(error);
      }
      navigate("/genders");

    }else{
      navigate("/genders");
    } 
  }

  const changeHandler = event =>{
    setInputValue(event.target.value);
  }

  return (
    <div>
      <p>{ message }</p>
      <form onSubmit={submitHandler}>
        <input type="text" value={ inputValue } onChange={ changeHandler }/>
        <div className="Submit-Buttons">
          <button onClick={() => { setSelected(true) }}>  <IoIosCheckmark/> </button>
          <button onClick={() => { setSelected(false) }}> <IoIosClose/>     </button>
        </div>
      </form>
    </div>
  )
}

export default EditGender;