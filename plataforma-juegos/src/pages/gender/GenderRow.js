import React from 'react';
import { Link } from "react-router-dom";

import { IoIosTrash, IoIosBuild } from 'react-icons/io';

const GenderRow = (props)=>{
  
  return(
    <>
      <div className="Row">
        <span>

          <p> {props.elem.index} - {props.elem.nombre}  </p>

          <Link to={`/genders/edit_gender/${props.elem.id}`}>
            <button className="Update-Button">
              <IoIosBuild />
            </button>
          </Link>

          <Link to={`/genders/delete_gender/${props.elem.id}`}>
            <button className="Delete-Button">
              <IoIosTrash/>
            </button>
          </Link>

        </span>
      </div>
      <hr/>
    </>
  )
}


export default GenderRow;
