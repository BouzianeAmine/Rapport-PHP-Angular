import { BrowserModule } from '@angular/platform-browser';
import { NgModule } from '@angular/core';
import { HttpClientModule } from '@angular/common/http';
import { AppComponent } from './app.component';
import { NavbarComponent } from './navbar/navbar.component';
import { HomeComponent } from './home/home.component';
import { RouterModule, Routes } from '@angular/router';
import { SignupComponent } from './signup/signup.component';
import { SigninComponent } from './signin/signin.component';
import { UpdateUserComponent } from './update-user/update-user.component';
import { BrowserAnimationsModule } from '@angular/platform-browser/animations';
import { FormsModule,ReactiveFormsModule  } from '@angular/forms';
import { RapportsComponent } from './rapports/rapports.component';
import { MatFormFieldModule } from '@angular/material/form-field';
import { MatTableModule, MatInputModule } from '@angular/material'
import { MatCardModule } from '@angular/material/card';
import {MatButtonModule} from '@angular/material/button';
import {MatStepperModule} from '@angular/material/stepper';

const routes: Routes = [
  {
    path: '',
    component:AppComponent
  },
  {
    path: 'home',
    component: HomeComponent
  },
  {
    path: 'signup',
    component: SignupComponent
  },
  {
    path: 'signin',
    component: SigninComponent
  },
  {
    path: 'updateUser',
    component: UpdateUserComponent
  },
  {
    path: 'rapports',
    component: RapportsComponent
  },
  {
    path: 'logout',
    redirectTo: '/signin'
  }
 
];

@NgModule({
  declarations: [
    AppComponent,
    NavbarComponent,
    HomeComponent,
    SignupComponent,
    SigninComponent,
    UpdateUserComponent,
    RapportsComponent
  ],
  imports: [
    BrowserModule,
    RouterModule,
    HttpClientModule,
    RouterModule.forRoot(routes),
    BrowserAnimationsModule,
    FormsModule,
    ReactiveFormsModule ,
    MatFormFieldModule,
    MatTableModule,
    MatInputModule,
    MatCardModule,
    MatButtonModule,
    MatStepperModule
  ],
  providers: [],
  bootstrap: [AppComponent]
})
export class AppModule { }
