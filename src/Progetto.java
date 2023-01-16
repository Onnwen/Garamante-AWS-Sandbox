import java.util.Scanner;

public class Progetto {
    private String nome;
    private int anno;
    private Dipendente[] dipendenti;

    public Progetto() {
        Scanner input = new Scanner(System.in);

        System.out.print("Inserire il nome del progetto:\n-> ");
        String nome = input.nextLine();

        System.out.print("Inserire l'anno di inizio del progetto:\n-> ");
        int anno = input.nextInt();

        System.out.print("Inserire il numero di dipendenti del progetto:\n-> ");
        int numeroDipendenti = input.nextInt();
        for(int i = 0; i < numeroDipendenti; i++) {
            System.out.println("Inserire i dati del dipendente " + (i + 1) + ":");
            aggiungiDipendente();
        }
    }

    public Progetto(String nome, int anno, Dipendente[] dipendenti) {
        this.nome = nome;
        this.anno = anno;
        this.dipendenti = dipendenti;
    }

    public void stampa() {
        System.out.println("Nome: " + nome);
        System.out.println("Anno: " + anno);
        System.out.println("Dipendenti:");
        for(int i = 0; i < dipendenti.length; i++) {
            System.out.println("Dipendente " + (i + 1) + ":");
            dipendenti[i].stampa();
        }
    }

    public aggiungiDipendente() {
        Dipendente[] dipendentiNuovi = new Dipende[dipendenti.length + 1];

        for (int i = 0; i < dipendenti.length; i++) {
            dipendentiNuovi[i] = dipendenti[i];
        }

        Scanner input = new Scanner(System.in);
        Dipendente dipendente = new Dipendente();

        System.out.print("Inserire il nome del dipendente:\n-> ");
        String nome = input.nextLine();

        System.out.print("Inserire il cognome del dipendente:\n-> ");
        String cognome = input.nextLine();

        System.out.print("Inserire il costo orario del dipendente:\n-> ");
        double costoOrario = input.nextDouble();

        System.out.print("Inserire le ore lavorate del dipendente:\n-> ");
        int oreLavorate = input.nextInt();

        dipendentiNuovi[dipendentiNuovi.length - 1] = new Dipendente(nome, cognome, costoOrario, oreLavorate);

        dipendenti = dipendentiNuovi;
    }

    public aggiungiDipendente(Dipendente dipendente) {
        Dipendente[] dipendentiNuovi = new Dipende[dipendenti.length + 1];

        for (int i = 0; i < dipendenti.length; i++) {
            dipendentiNuovi[i] = dipendenti[i];
        }
        dipendentiNuovi[dipendentiNuovi.length - 1] = dipendente;

        dipendenti = dipendentiNuovi;
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public int getAnno() {
        return anno;
    }

    public void setAnno(int anno) {
        this.anno = anno;
    }

    public Dipendente[] getDipendenti() {
        return dipendenti;
    }

    public void setDipendenti(Dipendente[] dipendenti) {
        this.dipendenti = dipendenti;
    }
}