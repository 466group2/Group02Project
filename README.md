# CSCI466Project
A repository for Group 02 project

Hey guys! This our CSCI 466 Databases repository!

In order to get this to work make sure you are checking the Blackboard group discussion board and discord. Make sure to keep the repository updated with documents relevant to the group so that we can all work on pieces of the project.

If anything is a pressing issue keep in mind that the Blackboard Group has the ability to e-mail each other or the whole group at once.





## Installing Git on your local machine(Windows):
 - Install git bash from the git website (if it suggests git gui with during the "Select Components" windows, you can uncheck that)
 - if you need a video this one is pretty straightforward for windows https://www.youtube.com/watch?v=qdwWe9COT9k (actual useful bit starts at 2:50)
 - if you use vscode you can change it to the default editor for git now. install with the defaults for the rest if you have no preference for them.
 - make sure git credential manager is enabled
 - once git bash is installed just right click somewhere on your desktop and you should be able to run a git bash!
 - create your gitconfig file by running (replace the stuff in quotes with your GitHub username and github email for the second command)

	$ git config --global user.name "John Doe"
	$ git config --global user.email johndoe@example.com


check the git config file in your user folder so that it looks something like this:

```
[user]
	name = YOUR_GITHUB_USERNAME_GOES_HERE
	email = YOUR_GITHUB_EMAIL_GOES_HERE
[fetch]
	prune = true
[credential]
	helper = 
	helper = manager
[credential "https://dev.azure.com"]
	usehttppath = true
[gui]
	recentrepo = YOUR_DEFAULT_REPO_PATH_GOES_HERE
[filter "lfs"]
	smudge = git-lfs smudge -- %f
	process = git-lfs filter-process
	required = true
	clean = git-lfs clean -- %f
```

Adding your git SSH key
 - If you haven't created and SSH key already, start up your git bash
 - run the below command to create your SSH key
	ssh-keygen -o
 - don't have to include a passphrase, just press enter
 - through file explorer go to folder specified by ssh gen as to where to find key (or cat the folder path for the id_rsa.pub the ssh gen gave) Make sure hidden items are checked in view.
 - open the file that is named id_rsa.pub
 - go to your github > profile > settings > ssh and gpg keys > new ssh key
 - paste the key from the id_rsa.pub file in the key box (give it whatever title you want) 
 - add!
your computer should now be linked with github. this is the same process with turing/hopper

Making your pc auto log in 

 - Not necessary from what I remember but saves a lot of time and headaches. Go to your disk > user > YOUR_USER_HERE 
 - if you don't see a .bashrc create one now by opening a git bash in your user folder (right click > git bash here) and running touch .bashrc
 - copy the following into the .bashrc file:

```
env=~/.ssh/agent.env

agent_load_env () { test -f "$env" && . "$env" >| /dev/null ; }

agent_start () {
    (umask 077; ssh-agent >| "$env")
    . "$env" >| /dev/null ; }

agent_load_env

# agent_run_state: 0=agent running w/ key; 1=agent w/o key; 2=agent not running
agent_run_state=$(ssh-add -l >| /dev/null 2>&1; echo $?)

if [ ! "$SSH_AUTH_SOCK" ] || [ $agent_run_state = 2 ]; then
    agent_start
    ssh-add
elif [ "$SSH_AUTH_SOCK" ] && [ $agent_run_state = 1 ]; then
    ssh-add
fi

unset env
```

Now whenever you run a git bash you should be able to commit, pull and everything from github. If you use vscode you just need to install the git extension and it'll work with github with no extra steps. Gonna add turing/hopper instructions once I set mine up as well...
