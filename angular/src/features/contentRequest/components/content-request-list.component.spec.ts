import { ComponentFixture, TestBed } from '@angular/core/testing';

import { ContentRequestListComponent } from './content-request-list.component';

describe('ContentRequestListComponent', () => {
  let component: ContentRequestListComponent;
  let fixture: ComponentFixture<ContentRequestListComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ ContentRequestListComponent ]
    })
    .compileComponents();

    fixture = TestBed.createComponent(ContentRequestListComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
