import { Component, OnInit, Input } from '@angular/core';
import { Router } from '@angular/router';
import { soldeBehavior, toString } from '../handlers/userSession';
import { User } from '../models/user';
import { UserService } from '../user.service';

@Component({
  selector: 'app-signin',
  templateUrl: './signin.component.html',
  styleUrls: ['./signin.component.css']
})
export class SigninComponent implements OnInit {
  @Input() email: string;
  @Input() password: string;
  error: string;
  errorcheck: boolean = false;
  constructor(private router: Router, private userService: UserService) { }

  ngOnInit() {
  }

  connect() {
    const user = {
      email: this.email,
      password: this.password
    };
    this.userService.connect(user).subscribe((user:User) => {
      if (user == undefined) {
        this.errorcheck = true;
        this.error = "Not the good cridentials";
        throw new Error(this.error);
      }
      this.router.navigate(['/home']).then(() => window.location.reload());
    });
  }

  
}
