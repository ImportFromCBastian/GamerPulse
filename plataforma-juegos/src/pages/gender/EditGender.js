import { useState, useEffect, useContext } from 'react';
import axios from 'axios';
import endpoints from '../../config/endpoints';
import { useParams, useNavigate } from 'react-router-dom';
import { IoIosCheckmark, IoIosClose } from 'react-icons/io';
import { MessageContext } from '../../config/messageContext';


const EditGender = () => {
  const { message,changeMessage } = useContext(MessageContext);
  const { id } = useParams("");
  const [ inputValue,setInputValue ] = useState("");
  const [selected, setSelected] = useState("");
  const navigate = useNavigate();
  

  useEffect(()=>{
    try {
      axios
        .get(`${endpoints.gender.fetch}${id}`)
        .then(response =>{
          setInputValue(response.data.nombre);
          changeMessage(`Modificando elemento ${response.data.nombre}`);
          
        })
    } catch (error) {
      console.log(error);
    };
  },[id]);

  const submitHandler = event => {
    changeMessage("");
    event.preventDefault();
    if(selected && inputValue !== ""){
      try{
        axios
          .put(`${endpoints.gender.put}${id}`, { nombre: inputValue }, { header: ('Access-Control-Allow-Origin', '*') })
          .then(response => {
            changeMessage(response.data.mensaje);
          });

      }catch(error){
        console.log(error);
      }
      
    }else{
      changeMessage("No se actualizo el genero");
    } 

    navigate("/genders");
  }

  const changeHandler = event =>{
    setInputValue(event.target.value);
  }

  return (
    <div>
      <p>{ message }</p>
      <form onSubmit={ submitHandler }>
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