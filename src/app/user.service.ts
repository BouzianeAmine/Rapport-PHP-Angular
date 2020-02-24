import { Injectable } from '@angular/core';
import { Observable } from 'rxjs';
import { User } from './models/user';
import { toString, soldeBehavior, stockSession, testSameConnectionDay, toJSON, getCurrentUser, stockHist } from './handlers/userSession';
import { environment } from 'src/environments/environment';

@Injectable({
  providedIn: 'root'
})
export class UserService {

  constructor() {  }

  connect(userCred): Observable<User> {
    return Observable.create(observer => {
      fetch(`${environment.server}/bootstrap.php/connect`, { method: 'POST', mode: 'cors', body: toString(userCred) })
        .then(value => value.json())
        .then((user) => {
          localStorage.setItem('auth', 'true');
          if (soldeBehavior(user)) {
            getCurrentUser().subscribe(user => {
              stockHist(user, Date.now())
            })
          } else {
            stockSession(user);
            stockHist(user)
          }
          getCurrentUser().subscribe(user => {
            this.update(user).then(cuser => {
              observer.next(cuser);
              observer.complete();
            });
          })
        })
    })
  }

  update(user: User): Promise<any> {
    return new Promise((resolve, reject) => {
      fetch(`${environment.server}/bootstrap.php/updateUser`, { method: 'POST', mode: 'cors', body: toString(user) })
        .then(res => res.json()).then((user: User) => {
          stockSession(user);
          resolve(user);
        }).catch(err => reject(err));
    })
  }

  signUp(user: User) {
    return new Promise((resolve, reject) => {
      fetch(`${environment.server}/bootstrap.php/signup`, { method: 'POST', mode: 'cors', body: toString(user) })
        .then(res => res.json()).then(user => resolve(user)).catch(err => reject(err));
    })
  }
}
