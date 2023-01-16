public class Progetti {
    private Progetto[] progetti;

    public Progetti() {
        System.out.println("Inserire il numero di progetti:");
        Scanner input = new Scanner(System.in);
        int numeroProgetti = input.nextInt();

        for (int i = 0; i < numeroProgetti; i++) {
            System.out.println("Inserire i dati del progetto " + (i + 1) + ":");
            aggiungiProgetto(new Progetto());
        }
    }

    public Progetti(Progetto[] progetti) {
        this.progetti = progetti;
    }

    public void stampa() {
        for (int i = 0; i < progetti.length; i++) {
            System.out.println("Progetto " + (i + 1) + ":");
            progetti[i].stampa();
        }
    }

    public void salva() {
        try {
            DocumentBuilderFactory docFactory = DocumentBuilderFactory.newInstance();
            DocumentBuilder docBuilder = docFactory.newDocumentBuilder();
            Document doc = docBuilder.newDocument();

            Element rootElement = doc.createElement("progetti");
            doc.appendChild(rootElement);

            for (int i = 0; i < progetti.length; i++) {
                Element progetto = doc.createElement("progetto");
                rootElement.appendChild(progetto);

                Element nome = doc.createElement("nome");
                nome.appendChild(doc.createTextNode(progetti[i].getNome()));
                progetto.appendChild(nome);

                Element anno = doc.createElement("anno");
                anno.appendChild(doc.createTextNode(progetti[i].getAnno()));
                progetto.appendChild(anno);

                Element dipendenti = doc.createElement("dipendenti");
                progetto.appendChild(dipendenti);

                for (int j = 0; j < progetti[i].getDipendenti().length; j++) {
                    Element dipendente = doc.createElement("dipendente");
                    dipendenti.appendChild(dipendente);

                    Element nomeDipendente = doc.createElement("nome");
                    nomeDipendente.appendChild(doc.createTextNode(progetti[i].getDipendenti()[j].getNome()));
                    dipendente.appendChild(nomeDipendente);

                    Element cognomeDipendente = doc.createElement("cognome");
                    cognomeDipendente.appendChild(doc.createTextNode(progetti[i].getDipendenti()[j].getCognome()));
                    dipendente.appendChild(cognomeDipendente);

                    Element costoOrarioDipendente = doc.createElement("costoOrario");
                    costoOrarioDipendente.appendChild(doc.createTextNode(progetti[i].getDipendenti()[j].getCostoOrario()));
                    dipendente.appendChild(costoOrarioDipendente);

                    Element oreLavorateDipendente = doc.createElement("oreLavorate");
                    oreLavorateDipendente.appendChild(doc.createTextNode(progetti[i].getDipendenti()[j].getOreLavorate()));
                    dipendente.appendChild(oreLavorateDipendente);
                }
            }
        } catch (IOException e) {
            System.out.println("Errore durante la scrittura del file");
        }
    }

    public void aggiungiProgetto(Progetto progetto) {
        Progetto[] progettiNuovi = new Progetto[progetti.length + 1];

        for (int i = 0; i < progetti.length; i++) {
            progettiNuovi[i] = progetti[i];
        }
        progettiNuovi[progettiNuovi.length - 1] = progetto;

        progetti = progettiNuovi;
    }

    public Progetto getLastProgetto() {
        return progetti[progetti.length - 1];
    }

    public Progetto[] getProgetti() {
        return progetti;
    }

    public void setProgetti(Progetto[] progetti) {
        this.progetti = progetti;
    }
}