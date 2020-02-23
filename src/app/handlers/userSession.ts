import { User } from '../models/user';
import { Observable } from 'rxjs';

export function getCurrentUser(): Observable<User> {
    return Observable.create(observer => {
        observer.next(toJSON(localStorage.getItem('user')));
        observer.complete();
    });
}

export function stockSession(user: User) {
    localStorage.setItem('user', toString(user));
}

export function soldeBehavior(user: User) {

    if (user != undefined) {
        if (testSameConnectionDay()) {
            console.log('im here where i shouldn"t be')
            updateSolde(1).then(user => stockSession(user))
            return true;
        }
        console.log('here instead where it should be now')
        return false;
    }
    throw new Error("Not connected to deal with it ");
}

export function toJSON(val) {
    return JSON.parse(val);
}

export function toString(val) {
    return JSON.stringify(val);
}

function dateDiff(d1, d2) {
    d1 = new Date(d1).getTime() / 1000;
    d2 = new Date(d2).getTime() / 1000;
    return d1 - d2;
}


export function updateSolde(val: number): Promise<User> {
    return new Promise<User>((resolve, reject) => {
        getCurrentUser().subscribe((user: User) => {
            if (new Number(user.solde).valueOf() == 0) reject(null)
            user.solde = new Number(user.solde).valueOf() + val;
            console.log(user);
            resolve(user);
        });
    })
}

export function testSameConnectionDay() {
    //console.log(Date.now(), toJSON(localStorage.getItem('hist')).date)
    var res;
    var cuser;
    getCurrentUser().subscribe(user => cuser = user);
    Array(toJSON(localStorage.getItem('hist'))).forEach(el => {
        if (el.user = cuser) {
            if (dateDiff(Date.now(), el.date) <= 86400) {
                res = false;
            } else res = true;
        }
    })
    return res;

}

export function stockHist(user, date?) {
    var hists = toJSON(localStorage.getItem('hist'))
    hists.forEach(el => {
        if (el.user == user) {
            if (date != null) el.date = date
        }
    })
    localStorage.setItem('hist', toString(hists));
}

export function addNewUsertoHist(user, date) {
    var hists = toJSON(localStorage.getItem('hist'));
    if (hists == null || hists == undefined) {
        hists = Array();
    }
    hists.push({ user, date })
    localStorage.setItem('hist', toString(hists))
}