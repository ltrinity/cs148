 Command line instructions
Git global setup

git config --global user.name "Robert Michael Erickson"
git config --global user.email "robert.erickson@uvm.edu"

Create a new repository

git clone git@gitlab.uvm.edu:robert-erickson/uvm-classes.git
cd uvm-classes
touch README.md
git add README.md
git commit -m "add README"
git push -u origin master

Existing folder or Git repository

cd existing_folder
git init
git remote add origin git@gitlab.uvm.edu:robert-erickson/uvm-classes.git
git add .
git commit
git push -u origin master
