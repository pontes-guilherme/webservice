import os

class Functions:

    @staticmethod
    def enter_to_continue():
        """Espera um [enter] do usuário
        """

        input()

    @staticmethod
    def menu():
        """Exibe um simples menu de opções. A opção é escolhida
        através da entrada de dados pelo usuário
        
        Returns:
            [int] -- Número da opção escolhida
        """

        os.system('cls')
        print("###############################################")
        print("1 - Listar passagens")
        print("2 - Informações da passagem (informando id):")
        print("3 - Comprar passagem:")
        print("4 - Listar hospedagens")
        print("5 - Informações da hospedagem (informando id):")
        print("3 - Comprar hospedagem")
        print("###############################################")

        opt = input("Digite a opção desejada: ")
        print("\n")

        return opt

    @staticmethod
    def print_dict_recursively(json, lvl=0):
        """Imprime um dicionário recursivamente. Cada chave será impressa. 
        Se seu valor for um dicionário, a função é chamada recursivamente;
        caso contrário, o valor é impresso juntamente com sua chave
        
        Arguments:
            json {dict} -- O dicionário a ser impresso
        
        Keyword Arguments:
            lvl {int} -- Nível para identação das impressões (default: {0})
        """
        
        for field in json:
            if type(json[field]) == str:
                print(" "*lvl,"%s: " % field, end="")
                print("%s" % json[field])
            elif json[field] and type(json[field]) == dict:
                print(" "*lvl,"%s:" % field)
                Functions.print_dict_recursively(json[field], lvl=lvl+2)
                print("\n")
