import React from 'react';
import { NavLink } from 'react-router-dom';

import './styles.scss';

import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faUpload } from '@fortawesome/free-solid-svg-icons';

export default function Menu() {
  return (
    <div className="menu">
      <ul className="menu-items">
        <li className="item">
          <NavLink to="/upload" activeClassName="actived"><FontAwesomeIcon icon={faUpload} size="1x"/> Upload</NavLink>
        </li>
      </ul>
    </div>
  );
}
