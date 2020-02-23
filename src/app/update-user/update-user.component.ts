import { Component, OnInit } from '@angular/core';
import { User } from '../models/user';
import { getCurrentUser } from '../handlers/userSession';
import { UserService } from '../user.service';

@Component({
  selector: 'app-update-user',
  templateUrl: './update-user.component.html',
  styleUrls: ['./update-user.component.css']
})
export class UpdateUserComponent implements OnInit {
  currentUser: User;
  constructor(private userService:UserService) {
    getCurrentUser().subscribe(user=>{this.currentUser=user});
  }

  ngOnInit() {

  }
  save() {
   this.userService.update(this.currentUser)
  }

}
