import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContentRequestDetailsComponent } from './content-request-details.component';

describe('ContentRequestDetailsComponent', () => {
  let component: ContentRequestDetailsComponent;
  let fixture: ComponentFixture<ContentRequestDetailsComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ContentRequestDetailsComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ContentRequestDetailsComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
