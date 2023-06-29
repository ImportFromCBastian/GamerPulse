import React from 'react';
import { Link } from "react-router-dom";

import { IoMdTrash } from 'react-icons/io';
import { IoPencil } from 'react-icons/io5';



const PlatformRow = (props) => {

    return (
    <>
      <div className="Row">
        <p> {props.elem.index+1} - {props.elem.nombre}  </p>

        <Link className="Change-Button" to={`/platforms/edit_platform/${props.elem.id}`}>
          <IoPencil />
        </Link>

        <Link className="Change-Button"  to={`/platforms/delete_platform/${props.elem.id}`}>
          <IoMdTrash />
        </Link>

      </div>
    </>
  )
}


export default PlatformRow;
