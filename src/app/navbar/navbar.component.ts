import { Component, OnInit } from '@angular/core';
import { getCurrentUser, toJSON, toString } from '../handlers/userSession';
import { User } from '../models/user';

@Component({
  selector: 'app-navbar',
  templateUrl: './navbar.component.html',
  styleUrls: ['./navbar.component.css']
})
export class NavbarComponent implements OnInit {
  isauth: Boolean;
  currentUser: User;
  constructor() {
    this.isauth = this.isAuth();
    getCurrentUser().subscribe(user => { this.currentUser = user });
  }

  ngOnInit() {
  }

  getSolde() {
    var solde = 0;
    getCurrentUser().subscribe(user => { solde = user.solde });
    return solde;
  }
  public isAuth() {
    return toJSON(localStorage.getItem('auth'));
  }
  logout() {
    fetch('http://localhost:8000/bootstrap.php/deconnect', { method: 'POST', mode: 'cors', body: toString(this.currentUser) })
      .then(res => {
        if (res.ok) {
          localStorage.setItem('user', null);
          localStorage.setItem('auth', 'false');
          this.isauth = toJSON(localStorage.getItem('auth'))
        }
      });
  }
}
