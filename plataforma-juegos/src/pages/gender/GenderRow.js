import React from 'react';
import { Link } from "react-router-dom";
import { IoMdTrash } from 'react-icons/io';
import { IoPencil } from 'react-icons/io5';

const GenderRow = (props)=>{
  
  return(
    <>
      <div className="Row">
        <p> {props.elem.index+1} - {props.elem.nombre}  </p>

        <Link className="Change-Button" to={`/genders/edit_gender/${props.elem.id}`}>
          <IoPencil />
        </Link>

        <Link className="Change-Button"  to={`/genders/delete_gender/${props.elem.id}`}>
            <IoMdTrash/>
        </Link>
      </div>
      
    </>
  )
}


export default GenderRow;
