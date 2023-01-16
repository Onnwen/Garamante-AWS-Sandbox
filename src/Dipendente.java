public class Dipendente {
    private String nome;
    private String cognome;
    private Double costoOrario;
    private int oreLavorate;

    public Dipendente(String nome, String cognome, Double costoOrario, int oreLavorate) {
        this.nome = nome;
        this.cognome = cognome;
        this.costoOrario = costoOrario;
        this.oreLavorate = oreLavorate;
    }

    public void stampa() {
        System.out.println("Nome e cognome: " + nome + " " + cognome + "\nCosto orario: " + costoOrario + "\nOre lavorate: " + oreLavorate);
    }

    public String getNome() {
        return nome;
    }

    public void setNome(String nome) {
        this.nome = nome;
    }

    public String getCognome() {
        return cognome;
    }

    public void setCognome(String cognome) {
        this.cognome = cognome;
    }

    public Double getCostoOrario() {
        return costoOrario;
    }

    public void setCostoOrario(Double costoOrario) {
        this.costoOrario = costoOrario;
    }

    public int getOreLavorate() {
        return oreLavorate;
    }

    public void setOreLavorate(int oreLavorate) {
        this.oreLavorate = oreLavorate;
    }
}