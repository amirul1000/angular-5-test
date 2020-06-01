import { Component, OnInit } from '@angular/core';

import {DataService} from '../data.service';
import { Observable } from 'rxjs/Observable';



@Component({
  selector: 'app-curd',
  templateUrl: './curd.component.html',
  styleUrls: ['./curd.component.scss']
})
export class CurdComponent implements OnInit {

   list : Observable<any>;
   test:string;
   msg:string;
   id : string;
   delete_id:string;
   addTxt:string;
   add_col1:string;
   add_col2:string;
   add_col3:string;


  constructor(public dataservice:DataService) {

  }

  ngOnInit() {
          this.getTestList();
  }

  getTestList()
  {
     this.dataservice.getTestList()
                   .subscribe(data => this.list=data);
  }

  showEditor(id:string)
  {

     if(id==''||id==undefined)
     {
       this.addTxt = "Add";
       id = '';
     }
     else
     {
       this.addTxt = "Update";
       this.dataservice.getEditedData(id)
                   .subscribe(data => {
                          this.add_col1 = data[0]['col1'];
                          this.add_col2 = data[0]['col2'];
                          this.add_col3 = data[0]['col3'];
                          this.id       = data[0]['id'];
                   });
     }
  }

  addTest()
  {
     let  jsonObj = { col1 : this.add_col1,col2 : this.add_col2,col3 : this.add_col3};
     this.dataservice.addTest(this.id,jsonObj)
            .subscribe(data => {
                     if(data[0]['status']=='success'){
                           this.msg = data[0]['msg'];
                           this.getTestList();

                           this.add_col1 = "";
                           this.add_col2 = "";
                           this.add_col3 = "";
                           this.id       = "";
                     }
            });

  }

  deleteTest()
  {
      let jsonObj = { 'id' : this.delete_id };
      this.dataservice.deleteTest(jsonObj)
             .subscribe(data => {
                      if(data[0]['status']=='success'){
                            this.msg = data[0]['msg'];
                            this.getTestList();
                      }
             });
  }

  setDeletedId(id:string)
  {
     this.delete_id = id;
  }

}
