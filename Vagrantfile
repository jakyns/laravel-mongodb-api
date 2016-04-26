# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  if File.directory?(File.expand_path("./api"))
    config.vm.synced_folder "api/storage", "/vagrant/api/storage", :mount_options => ["dmode=777", "fmode=666"]
  end

  config.vm.network "forwarded_port", guest: 80, host: 8080
  config.vm.network "private_network", ip: "192.168.10.10"

  config.vm.provider "virtualbox" do |vb|
    vb.name = "Laravel with MongoDB API"
  end

  config.vm.provision "ansible" do |ansible|
    ansible.playbook = "Playbooks/vagrant.yml"
    ansible.verbose = "vv"

    ansible.vault_password_file = "Playbooks/.vault_password/vagrant"

    ansible.groups = {
      "vagrant" => ["default"],
    }
  end
end
