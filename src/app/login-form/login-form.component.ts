import {Component, HostListener, Input} from '@angular/core';
import {FormBuilder, FormControl, Validators} from '@angular/forms';
import {HttpClient} from "@angular/common/http";

@Component({
  selector: 'app-login-form',
  templateUrl: './login-form.component.html',
  styleUrls: ['./login-form.component.css']
})

export class LoginFormComponent {
  @Input() credentials = {
    email: '',
    password: ''
  }

  emailFormControl = new FormControl('', [Validators.required, Validators.email]);
  passwordFormControllo = new FormControl('', [Validators.required]);
  constructor(public http: HttpClient) {}

  onSubmit(event: { preventDefault: () => void; }): void {
    event.preventDefault();
    this.http.post<any>('https://api.garamante.it/MathRevealer/myAccount/login', {
      email: this.credentials.email,
      password: this.credentials.password
    }).subscribe(data => {
      if (data.status_code == 1) {
        alert("Autenticato come " + data.userInformation.first_name + " " + data.userInformation.last_name + ".");
      }
      else {
        alert("Credenziali errate.");
      }
    })
  }

}

