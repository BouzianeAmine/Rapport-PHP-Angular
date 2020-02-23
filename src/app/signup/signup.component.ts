import { Component, OnInit, Input } from '@angular/core';
import {validate} from '../../../middleWears/validator'
import { UserService } from '../user.service';
import { User } from '../models/user';
import { addNewUsertoHist } from '../handlers/userSession';
import { Router } from '@angular/router';
@Component({
  selector: 'app-signup',
  templateUrl: './signup.component.html',
  styleUrls: ['./signup.component.css']
})
export class SignupComponent implements OnInit {
  
  user:User={email:"",firstname:"",lastname:"",linkedin:"",naissance:"",password:"",promotion:"",telephone:""};
  
  constructor(private userS:UserService,private router:Router) { }

  ngOnInit() {
  }
  
  signUp(){
    validate(this.user.email)
    .then(res=>{
      this.userS.signUp(this.user).then((user:User)=>{
        addNewUsertoHist(user,Date.now())
        this.userS.connect({email:user.email,password:user.password}).subscribe(user=>this.router.navigate(['/home']).then(() => window.location.reload()))
      });
    })
    .catch(err=>console.error(err));
  }

}
