import React from 'react';

const Dropdown = ({ name, placeholder, value, options, onChange }) => {
  return (
    <select className="Dropdown" name={name} value={value} onChange={onChange}>
      <option value=''>{placeholder}</option>
      {options.map((option) => (
        <option key={option.id} value={option.id}>{option.nombre}</option>
      ))}
    </select>
  );
};

export default Dropdown;
