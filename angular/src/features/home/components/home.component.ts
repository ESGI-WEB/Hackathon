import {Component, OnInit, ViewEncapsulation} from '@angular/core';

@Component({
  selector: 'app-main',
  templateUrl: './home.component.html',
  styleUrls: ['./home.component.scss'],
  encapsulation: ViewEncapsulation.None
})
export class HomeComponent implements OnInit {
  constructor() { }

  ngOnInit(): void {}

}
