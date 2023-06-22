import React from 'react';
import { Link } from "react-router-dom";

import { IoIosTrash, IoIosBuild } from 'react-icons/io';


const PlatformRow = (props) => {

    return (
    <>
      <div className="Row">
        <span>
          <p> {props.elem.index} - {props.elem.nombre}  </p>
          <Link to={`/platforms/edit_platform/${props.elem.id}/${props.elem.nombre}`}>
            <button className="Update-Button">
              <IoIosBuild />
            </button>
          </Link>

          <Link to={`/platforms/delete_platform/${props.elem.id}/${props.elem.nombre}`}>
            <button className="Delete-Button">
              <IoIosTrash />
            </button>
          </Link>

        </span>
      </div>
    </>
  )
}


export default PlatformRow;
