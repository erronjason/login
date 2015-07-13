# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"
  config.vm.provision :shell, path: "scripts/bootstrap.sh"
  config.vm.synced_folder "app/", "/var/www/html",
    owner: "www-data", group: "www-data"
  config.vm.network "forwarded_port", guest: 80, host: 8080

  config.vm.provider "virtualbox" do |vm|
    vm.memory = 2048
    vm.cpus = 2
    vm.customize ["modifyvm", :id, "--cpuexecutioncap", "90"]
  end

end
